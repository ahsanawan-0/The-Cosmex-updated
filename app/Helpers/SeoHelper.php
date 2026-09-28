<?php

namespace App\Helpers;

use App\Models\Setting;
use Illuminate\Support\Str;

class SeoHelper
{
    /** Longest title we will extend with the brand suffix. */
    private const MAX_TITLE = 65;

    /**
     * Append the brand to a page title unless it already names the brand or
     * the result would be too long for a search result.
     */
    public static function title(?string $pageTitle): string
    {
        $brand = config('site.name');
        $pageTitle = self::clean($pageTitle);

        if ($pageTitle === '') {
            return $brand;
        }

        if (Str::contains(Str::lower($pageTitle), 'cosmex')) {
            return $pageTitle;
        }

        $branded = "{$pageTitle} | {$brand}";

        return mb_strlen($branded) <= self::MAX_TITLE ? $branded : $pageTitle;
    }

    /**
     * Plain-text description that never ends mid-word: cut back to the last
     * full sentence, or failing that the last clause, within $max characters.
     */
    public static function description(?string $text, int $max = 160): string
    {
        $text = self::clean(strip_tags((string) $text));

        if ($text === '') {
            return '';
        }

        $length = mb_strlen($text);
        $complete = (bool) preg_match('/[.!?]$/u', $text);

        // Short enough and not cut off by an earlier length limit: keep it whole.
        if ($length <= $max && ($complete || $length < $max - 1)) {
            return $complete ? $text : rtrim($text, " ,;:-") . '.';
        }

        // Too long, or stored already truncated at the limit: cut back cleanly.
        $cut = mb_substr($text, 0, min($length, $max));

        // Keep as much as possible: the later of the last sentence end and the
        // last clause break (comma/semicolon), as long as enough text remains.
        $sentenceEnd = max(
            (int) mb_strrpos($cut, '. '),
            (int) mb_strrpos($cut, '! '),
            (int) mb_strrpos($cut, '? '),
        );
        $clauseEnd = max((int) mb_strrpos($cut, ','), (int) mb_strrpos($cut, ';'));

        if (max($sentenceEnd, $clauseEnd) >= 70) {
            return $sentenceEnd >= $clauseEnd
                ? mb_substr($cut, 0, $sentenceEnd + 1)
                : rtrim(mb_substr($cut, 0, $clauseEnd), " ,;:-") . '.';
        }

        // No clean break: stop at the last whole word and mark the cut.
        $space = mb_strrpos(mb_substr($cut, 0, $max - 1), ' ');

        return rtrim(mb_substr($cut, 0, $space !== false && $space >= 70 ? $space : $max - 1), " ,;:-") . '…';
    }

    /** Decode entities once and collapse whitespace, so Blade escapes exactly once. */
    public static function clean(?string $value): string
    {
        $value = html_entity_decode((string) $value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        // A second pass repairs values that were stored already escaped.
        $value = html_entity_decode($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        return trim(preg_replace('/\s+/u', ' ', $value) ?? '');
    }

    /** Local phone number (0328-4333364) in international form (+92-328-4333364). */
    public static function internationalPhone(?string $phone): ?string
    {
        $digits = preg_replace('/\D+/', '', (string) $phone);

        if ($digits === '') {
            return null;
        }

        if (Str::startsWith($digits, '0')) {
            $digits = '92' . substr($digits, 1);
        }

        return '+' . substr($digits, 0, 2) . '-' . substr($digits, 2, 3) . '-' . substr($digits, 5);
    }

    /** Stable @id used to reference the business from every other schema node. */
    public static function organizationId(): string
    {
        return url('/') . '/#organization';
    }

    /**
     * Sitewide Organization / LocalBusiness and WebSite graph, built from the
     * same settings that feed the header, footer and contact page.
     */
    public static function siteSchema(): array
    {
        $sameAs = array_values(array_filter([
            Setting::get('social_instagram'),
            Setting::get('social_facebook'),
            Setting::get('social_tiktok'),
        ], fn ($url) => is_string($url) && Str::startsWith($url, 'http')));

        $organization = array_filter([
            '@type' => ['Organization', 'LocalBusiness'],
            '@id' => self::organizationId(),
            'name' => config('site.name'),
            'legalName' => config('site.legal_name'),
            'url' => url('/') . '/',
            'logo' => url(config('site.logo')),
            'image' => url(config('site.og_image')),
            'description' => config('site.tagline') . ' for clinics, dermatologists and aesthetic professionals across Pakistan.',
            'email' => Setting::get('contact_email'),
            'telephone' => self::internationalPhone(Setting::get('contact_phone')),
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => config('site.street'),
                'addressLocality' => config('site.city'),
                'addressRegion' => config('site.region'),
                'addressCountry' => config('site.country'),
            ],
            'areaServed' => ['@type' => 'Country', 'name' => 'Pakistan'],
            'sameAs' => $sameAs ?: null,
        ]);

        return [
            '@context' => 'https://schema.org',
            '@graph' => [
                $organization,
                [
                    '@type' => 'WebSite',
                    '@id' => url('/') . '/#website',
                    'name' => config('site.name'),
                    'alternateName' => config('site.legal_name'),
                    'url' => url('/') . '/',
                    'inLanguage' => 'en',
                    'publisher' => ['@id' => self::organizationId()],
                ],
            ],
        ];
    }

    /** JSON for a <script type="application/ld+json"> block. */
    public static function json(array $data): string
    {
        return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
    }

    /** Price as shown on the page: whole rupees, no separators. */
    public static function schemaPrice(float|int|string|null $price): string
    {
        return (string) (int) round((float) $price);
    }
}
