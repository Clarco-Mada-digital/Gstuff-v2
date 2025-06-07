<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = DB::table('categories')->pluck('id', 'display_name')->toArray(); // Récupérer les IDs des categories

        $services = [
            // Services pour la catégorie 'escort'
            [
                'nom' => ['fr' => '69', 'en-US' => '69', 'es' => '69', 'de' => '69', 'it' => '69'],
                'categorie_id' => $categories['escort'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Anulingus (actif)',
                    'en-US' => 'Anilingus (active)',
                    'es' => 'Anilingus (activo)',
                    'de' => 'Anilingus (aktiv)',
                    'it' => 'Anilingus (attivo)',
                ],
                'categorie_id' => $categories['escort'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Anulingus (passif)',
                    'en-US' => 'Anilingus (passive)',
                    'es' => 'Anilingus (pasivo)',
                    'de' => 'Anilingus (passiv)',
                    'it' => 'Anilingus (passivo)',
                ],
                'categorie_id' => $categories['escort'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Branlette seins',
                    'en-US' => 'Titty fuck',
                    'es' => 'Paja con tetas',
                    'de' => 'Tittenfick',
                    'it' => 'Pompino tra le tette',
                ],
                'categorie_id' => $categories['escort'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Café Pipe',
                    'en-US' => 'Coffee Blowjob',
                    'es' => 'Mamada con café',
                    'de' => 'Kaffee Blowjob',
                    'it' => 'Pompino al caffè',
                ],
                'categorie_id' => $categories['escort'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Champagne doré actif',
                    'en-US' => 'Golden shower (active)',
                    'es' => 'Lluvia dorada (activo)',
                    'de' => 'Goldener Regen (aktiv)',
                    'it' => 'Doccia dorata (attivo)',
                ],
                'categorie_id' => $categories['escort'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Champagne doré passif',
                    'en-US' => 'Golden shower (passive)',
                    'es' => 'Lluvia dorada (pasivo)',
                    'de' => 'Goldener Regen (passiv)',
                    'it' => 'Doccia dorata (passivo)',
                ],
                'categorie_id' => $categories['escort'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Couple',
                    'en-US' => 'Couple',
                    'es' => 'Pareja',
                    'de' => 'Paar',
                    'it' => 'Coppia',
                ],
                'categorie_id' => $categories['escort'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Cunnilingus',
                    'en-US' => 'Cunnilingus',
                    'es' => 'Cunnilingus',
                    'de' => 'Cunnilingus',
                    'it' => 'Cunnilingus',
                ],
                'categorie_id' => $categories['escort'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Doigté anal',
                    'en-US' => 'Anal fingering',
                    'es' => 'Dedos en el culo',
                    'de' => 'Anales Fingern',
                    'it' => 'Ditalino anale',
                ],
                'categorie_id' => $categories['escort'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Doigté vaginal',
                    'en-US' => 'Vaginal fingering',
                    'es' => 'Dedos en la vagina',
                    'de' => 'Vaginales Fingern',
                    'it' => 'Ditalino vaginale',
                ],
                'categorie_id' => $categories['escort'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Domination soft',
                    'en-US' => 'Soft domination',
                    'es' => 'Dominación suave',
                    'de' => 'Sanfte Dominanz',
                    'it' => 'Dominazione leggera',
                ],
                'categorie_id' => $categories['escort'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Double pénétration',
                    'en-US' => 'Double penetration',
                    'es' => 'Doble penetración',
                    'de' => 'Doppelte Penetration',
                    'it' => 'Doppia penetrazione',
                ],
                'categorie_id' => $categories['escort'] ?? null,
            ],
            [
                'nom' => ['fr' => 'Duo', 'en-US' => 'Duo', 'es' => 'Dúo', 'de' => 'Duo', 'it' => 'Duo'],
                'categorie_id' => $categories['escort'] ?? null,
            ],

            [
                'nom' => [
                    'fr' => 'Ejaculation corps',
                    'en-US' => 'Body Ejaculation',
                    'es' => 'Eyaculación corporal',
                    'de' => 'Körper Ejakulation',
                    'it' => 'Eiaculazione sul corpo',
                ],
                'categorie_id' => $categories['escort'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Ejaculation faciale',
                    'en-US' => 'Facial Ejaculation',
                    'es' => 'Eyaculación facial',
                    'de' => 'Gesicht Ejakulation',
                    'it' => 'Eiaculazione sul viso',
                ],
                'categorie_id' => $categories['escort'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Ejaculation multiple OK',
                    'en-US' => 'Multiple Ejaculation OK',
                    'es' => 'Eyaculación múltiple OK',
                    'de' => 'Mehrfach Ejakulation OK',
                    'it' => 'Eiaculazione multipla OK',
                ],
                'categorie_id' => $categories['escort'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Facesitting',
                    'en-US' => 'Facesitting',
                    'es' => 'Facesitting',
                    'de' => 'Gesichtssitzen',
                    'it' => 'Facesitting',
                ],
                'categorie_id' => $categories['escort'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Femme Fontaine',
                    'en-US' => 'Squirting Woman',
                    'es' => 'Mujer Fontanera',
                    'de' => 'Spritzende Frau',
                    'it' => 'Donna che schizza',
                ],
                'categorie_id' => $categories['escort'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Fessées Acceptées',
                    'en-US' => 'Spanking Accepted',
                    'es' => 'Azotes Aceptados',
                    'de' => 'Spanking Akzeptiert',
                    'it' => 'Schiaffi Accettati',
                ],
                'categorie_id' => $categories['escort'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Fétichisme',
                    'en-US' => 'Fetishism',
                    'es' => 'Fetichismo',
                    'de' => 'Fetischismus',
                    'it' => 'Feticismo',
                ],
                'categorie_id' => $categories['escort'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'French Kiss',
                    'en-US' => 'French Kiss',
                    'es' => 'Besos con Lengua',
                    'de' => 'Französischer Kuss',
                    'it' => 'Bacio alla Francese',
                ],
                'categorie_id' => $categories['escort'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'GFE',
                    'en-US' => 'Girlfriend Experience',
                    'es' => 'Experiencia de Novia',
                    'de' => 'Freundin-Erlebnis',
                    'it' => 'Esperienza da Fidanzata',
                ],
                'categorie_id' => $categories['escort'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Gorge Profonde',
                    'en-US' => 'Deep Throat',
                    'es' => 'Garganta Profunda',
                    'de' => 'Tiefen Kehle',
                    'it' => 'Gola Profonda',
                ],
                'categorie_id' => $categories['escort'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Jeux de rôles',
                    'en-US' => 'Role Playing',
                    'es' => 'Juegos de Rol',
                    'de' => 'Rollenspiele',
                    'it' => 'Giochi di Ruolo',
                ],
                'categorie_id' => $categories['escort'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Lingerie',
                    'en-US' => 'Lingerie',
                    'es' => 'Lencería',
                    'de' => 'Dessous',
                    'it' => 'Biancheria Intima',
                ],
                'categorie_id' => $categories['escort'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Massage érotique',
                    'en-US' => 'Erotic Massage',
                    'es' => 'Masaje Erótico',
                    'de' => 'Erotische Massage',
                    'it' => 'Massaggio Erotico',
                ],
                'categorie_id' => $categories['escort'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Masturbation',
                    'en-US' => 'Masturbation',
                    'es' => 'Masturbación',
                    'de' => 'Masturbation',
                    'it' => 'Masturbazione',
                ],
                'categorie_id' => $categories['escort'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Porn Star Experience',
                    'en-US' => 'Porn Star Experience',
                    'es' => 'Experiencia Estrella Porno',
                    'de' => 'Pornostar-Erlebnis',
                    'it' => 'Esperienza da Star del Porno',
                ],
                'categorie_id' => $categories['escort'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Rapport Sexuel',
                    'en-US' => 'Sexual Intercourse',
                    'es' => 'Relación Sexual',
                    'de' => 'Geschlechtsverkehr',
                    'it' => 'Rapporto Sessuale',
                ],
                'categorie_id' => $categories['escort'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Service VIP',
                    'en-US' => 'VIP Service',
                    'es' => 'Servicio VIP',
                    'de' => 'VIP-Service',
                    'it' => 'Servizio VIP',
                ],
                'categorie_id' => $categories['escort'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Sexe de groupe (orgie)',
                    'en-US' => 'Group Sex (Orgy)',
                    'es' => 'Sexo en Grupo (Orgía)',
                    'de' => 'Gruppensex (Orgie)',
                    'it' => 'Sesso di Gruppo (Orgia)',
                ],
                'categorie_id' => $categories['escort'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Sex Toys',
                    'en-US' => 'Sex Toys',
                    'es' => 'Juguetes Sexuales',
                    'de' => 'Sexspielzeug',
                    'it' => 'Sex Toys',
                ],
                'categorie_id' => $categories['escort'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Sodomie (active)',
                    'en-US' => 'Anal Sex (Active)',
                    'es' => 'Sodomía (Activa)',
                    'de' => 'Analverkehr (Aktiv)',
                    'it' => 'Sodomia (Attiva)',
                ],
                'categorie_id' => $categories['escort'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Sodomie (passive)',
                    'en-US' => 'Anal Sex (Passive)',
                    'es' => 'Sodomía (Pasiva)',
                    'de' => 'Analverkehr (Passiv)',
                    'it' => 'Sodomia (Passiva)',
                ],
                'categorie_id' => $categories['escort'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Soumise',
                    'en-US' => 'Submissive',
                    'es' => 'Sumisa',
                    'de' => 'Unterwürfig',
                    'it' => 'Sottomessa',
                ],
                'categorie_id' => $categories['escort'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Stripteas',
                    'en-US' => 'Striptease',
                    'es' => 'Striptease',
                    'de' => 'Striptease',
                    'it' => 'Spogliarello',
                ],
                'categorie_id' => $categories['escort'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Drainage lymphatique',
                    'en-US' => 'Lymphatic Drainage',
                    'es' => 'Drenaje Linfático',
                    'de' => 'Lymphdrainage',
                    'it' => 'Drenaggio Linfatico',
                ],
                'categorie_id' => $categories['masseuse-no-sex'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Massage 4 mains',
                    'en-US' => '4-Hand Massage',
                    'es' => 'Masaje a 4 Manos',
                    'de' => '4-Hände-Massage',
                    'it' => 'Massaggio a 4 Mani',
                ],
                'categorie_id' => $categories['masseuse-no-sex'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Massage 6 mains',
                    'en-US' => '6-Hand Massage',
                    'es' => 'Masaje a 6 Manos',
                    'de' => '6-Hände-Massage',
                    'it' => 'Massaggio a 6 Mani',
                ],
                'categorie_id' => $categories['masseuse-no-sex'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Massage abdominal',
                    'en-US' => 'Abdominal Massage',
                    'es' => 'Masaje Abdominal',
                    'de' => 'Bauchmassage',
                    'it' => 'Massaggio Addominale',
                ],
                'categorie_id' => $categories['masseuse-no-sex'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Massage antistress',
                    'en-US' => 'Anti-Stress Massage',
                    'es' => 'Masaje Antiestrés',
                    'de' => 'Anti-Stress-Massage',
                    'it' => 'Massaggio Antistress',
                ],
                'categorie_id' => $categories['masseuse-no-sex'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Massage Australien',
                    'en-US' => 'Australian Massage',
                    'es' => 'Masaje Australiano',
                    'de' => 'Australische Massage',
                    'it' => 'Massaggio Australiano',
                ],
                'categorie_id' => $categories['masseuse-no-sex'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Massage aux huiles',
                    'en-US' => 'Oil Massage',
                    'es' => 'Masaje con Aceites',
                    'de' => 'Ölmassage',
                    'it' => 'Massaggio con Oli',
                ],
                'categorie_id' => $categories['masseuse-no-sex'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Massage ayurvédique',
                    'en-US' => 'Ayurvedic Massage',
                    'es' => 'Masaje Ayurvédico',
                    'de' => 'Ayurvedische Massage',
                    'it' => 'Massaggio Ayurvedico',
                ],
                'categorie_id' => $categories['masseuse-no-sex'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Massage body body',
                    'en-US' => 'Body to Body Massage',
                    'es' => 'Masaje Cuerpo a Cuerpo',
                    'de' => 'Body-to-Body-Massage',
                    'it' => 'Massaggio Corpo a Corpo',
                ],
                'categorie_id' => $categories['masseuse-no-sex'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Massage californien',
                    'en-US' => 'Californian Massage',
                    'es' => 'Masaje Californiano',
                    'de' => 'Kalifornische Massage',
                    'it' => 'Massaggio Californiano',
                ],
                'categorie_id' => $categories['masseuse-no-sex'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Massage douche',
                    'en-US' => 'Shower Massage',
                    'es' => 'Masaje en la Ducha',
                    'de' => 'Duschenmassage',
                    'it' => 'Massaggio sotto la Doccia',
                ],
                'categorie_id' => $categories['masseuse-no-sex'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Massage en Couple',
                    'en-US' => 'Couple Massage',
                    'es' => 'Masaje en Pareja',
                    'de' => 'Paarmassage',
                    'it' => 'Massaggio di Coppia',
                ],
                'categorie_id' => $categories['masseuse-no-sex'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Massage Jacuzzi',
                    'en-US' => 'Jacuzzi Massage',
                    'es' => 'Masaje en Jacuzzi',
                    'de' => 'Jacuzzi-Massage',
                    'it' => 'Massaggio in Jacuzzi',
                ],
                'categorie_id' => $categories['masseuse-no-sex'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Massage Naturiste',
                    'en-US' => 'Naturist Massage',
                    'es' => 'Masaje Naturista',
                    'de' => 'Naturistische Massage',
                    'it' => 'Massaggio Naturista',
                ],
                'categorie_id' => $categories['masseuse-no-sex'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Massage oriental',
                    'en-US' => 'Oriental Massage',
                    'es' => 'Masaje Oriental',
                    'de' => 'Orientale Massage',
                    'it' => 'Massaggio Orientale',
                ],
                'categorie_id' => $categories['masseuse-no-sex'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Massage prostate',
                    'en-US' => 'Prostate Massage',
                    'es' => 'Masaje de Próstata',
                    'de' => 'Prostatamassage',
                    'it' => 'Massaggio alla Prostata',
                ],
                'categorie_id' => $categories['masseuse-no-sex'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Massage Réciproque',
                    'en-US' => 'Reciprocal Massage',
                    'es' => 'Masaje Recíproco',
                    'de' => 'Gegenseitige Massage',
                    'it' => 'Massaggio Reciproco',
                ],
                'categorie_id' => $categories['masseuse-no-sex'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Massage Shiatsu',
                    'en-US' => 'Shiatsu Massage',
                    'es' => 'Masaje Shiatsu',
                    'de' => 'Shiatsu-Massage',
                    'it' => 'Massaggio Shiatsu',
                ],
                'categorie_id' => $categories['masseuse-no-sex'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Massage Suédois',
                    'en-US' => 'Swedish Massage',
                    'es' => 'Masaje Sueco',
                    'de' => 'Schwedische Massage',
                    'it' => 'Massaggio Svedese',
                ],
                'categorie_id' => $categories['masseuse-no-sex'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Massage tantra',
                    'en-US' => 'Tantra Massage',
                    'es' => 'Masaje Tántrico',
                    'de' => 'Tantra-Massage',
                    'it' => 'Massaggio Tantrico',
                ],
                'categorie_id' => $categories['masseuse-no-sex'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Massage thaïlandais',
                    'en-US' => 'Thai Massage',
                    'es' => 'Masaje Tailandés',
                    'de' => 'Thai-Massage',
                    'it' => 'Massaggio Tailandese',
                ],
                'categorie_id' => $categories['masseuse-no-sex'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Séance Hydromassage',
                    'en-US' => 'Hydromassage Session',
                    'es' => 'Sesión de Hidromasaje',
                    'de' => 'Hydromassage-Sitzung',
                    'it' => 'Seduta di Idromassaggio',
                ],
                'categorie_id' => $categories['masseuse-no-sex'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Asphyxie érotique',
                    'en-US' => 'Erotic Asphyxiation',
                    'es' => 'Asfixia Erótica',
                    'de' => 'Erotische Asphyxie',
                    'it' => 'Asfissia Erotica',
                ],
                'categorie_id' => $categories['dominatrice-bdsm'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Ballbusting',
                    'en-US' => 'Ballbusting',
                    'es' => 'Ballbusting',
                    'de' => 'Ballbusting',
                    'it' => 'Ballbusting',
                ],
                'categorie_id' => $categories['dominatrice-bdsm'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Bondage',
                    'en-US' => 'Bondage',
                    'es' => 'Bondage',
                    'de' => 'Bondage',
                    'it' => 'Bondage',
                ],
                'categorie_id' => $categories['dominatrice-bdsm'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Camisoles',
                    'en-US' => 'Straightjackets',
                    'es' => 'Camisas de Fuerza',
                    'de' => 'Zwangjacken',
                    'it' => 'Camicie di Forza',
                ],
                'categorie_id' => $categories['dominatrice-bdsm'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Caviar actif',
                    'en-US' => 'Active Caviar',
                    'es' => 'Caviar Activo',
                    'de' => 'Aktiver Kaviar',
                    'it' => 'Caviale Attivo',
                ],
                'categorie_id' => $categories['dominatrice-bdsm'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Caviar passif',
                    'en-US' => 'Passive Caviar',
                    'es' => 'Caviar Pasivo',
                    'de' => 'Passiver Kaviar',
                    'it' => 'Caviale Passivo',
                ],
                'categorie_id' => $categories['dominatrice-bdsm'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Champagne doré actif',
                    'en-US' => 'Active Golden Shower',
                    'es' => 'Ducha Dorada Activa',
                    'de' => 'Aktiver Goldener Regen',
                    'it' => 'Doccia Dorata Attiva',
                ],
                'categorie_id' => $categories['dominatrice-bdsm'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Champagne doré passif',
                    'en-US' => 'Passive Golden Shower',
                    'es' => 'Ducha Dorada Pasiva',
                    'de' => 'Passiver Goldener Regen',
                    'it' => 'Doccia Dorata Passiva',
                ],
                'categorie_id' => $categories['dominatrice-bdsm'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Chantage',
                    'en-US' => 'Blackmail',
                    'es' => 'Chantaje',
                    'de' => 'Erpressung',
                    'it' => 'Ricatto',
                ],
                'categorie_id' => $categories['dominatrice-bdsm'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Domination hard',
                    'en-US' => 'Hard Domination',
                    'es' => 'Dominación Fuerte',
                    'de' => 'Harte Dominanz',
                    'it' => 'Dominazione Forte',
                ],
                'categorie_id' => $categories['dominatrice-bdsm'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Electro stimulation',
                    'en-US' => 'Electro Stimulation',
                    'es' => 'Electroestimulación',
                    'de' => 'Elektrostimulation',
                    'it' => 'Elettrostimolazione',
                ],
                'categorie_id' => $categories['dominatrice-bdsm'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Enfermement',
                    'en-US' => 'Confinement',
                    'es' => 'Confinamiento',
                    'de' => 'Einschließung',
                    'it' => 'Confinamento',
                ],
                'categorie_id' => $categories['dominatrice-bdsm'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Etranglement',
                    'en-US' => 'Strangulation',
                    'es' => 'Estrangulamiento',
                    'de' => 'Erwürgen',
                    'it' => 'Strangolamento',
                ],
                'categorie_id' => $categories['dominatrice-bdsm'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Exhibition',
                    'en-US' => 'Exhibitionism',
                    'es' => 'Exhibicionismo',
                    'de' => 'Exhibitionismus',
                    'it' => 'Esibizionismo',
                ],
                'categorie_id' => $categories['dominatrice-bdsm'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Facesitting',
                    'en-US' => 'Facesitting',
                    'es' => 'Facesitting',
                    'de' => 'Gesichtssitzen',
                    'it' => 'Facesitting',
                ],
                'categorie_id' => $categories['dominatrice-bdsm'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Féminisation',
                    'en-US' => 'Feminization',
                    'es' => 'Feminización',
                    'de' => 'Feminisierung',
                    'it' => 'Femminilizzazione',
                ],
                'categorie_id' => $categories['dominatrice-bdsm'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Fessée active',
                    'en-US' => 'Active Spanking',
                    'es' => 'Azotes Activos',
                    'de' => 'Aktives Spanking',
                    'it' => 'Schiaffi Attivi',
                ],
                'categorie_id' => $categories['dominatrice-bdsm'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Fessée passive',
                    'en-US' => 'Passive Spanking',
                    'es' => 'Azotes Pasivos',
                    'de' => 'Passives Spanking',
                    'it' => 'Schiaffi Passivi',
                ],
                'categorie_id' => $categories['dominatrice-bdsm'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Fétichisme',
                    'en-US' => 'Fetishism',
                    'es' => 'Fetichismo',
                    'de' => 'Fetischismus',
                    'it' => 'Feticismo',
                ],
                'categorie_id' => $categories['dominatrice-bdsm'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Fisting actif',
                    'en-US' => 'Active Fisting',
                    'es' => 'Fisting Activo',
                    'de' => 'Aktives Fisting',
                    'it' => 'Fisting Attivo',
                ],
                'categorie_id' => $categories['dominatrice-bdsm'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Fisting passif',
                    'en-US' => 'Passive Fisting',
                    'es' => 'Fisting Pasivo',
                    'de' => 'Passives Fisting',
                    'it' => 'Fisting Passivo',
                ],
                'categorie_id' => $categories['dominatrice-bdsm'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Humiliations',
                    'en-US' => 'Humiliations',
                    'es' => 'Humillaciones',
                    'de' => 'Demütigungen',
                    'it' => 'Umiliazioni',
                ],
                'categorie_id' => $categories['dominatrice-bdsm'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Jeux de bougie',
                    'en-US' => 'Candle Play',
                    'es' => 'Juegos de Velas',
                    'de' => 'Kerzen Spiel',
                    'it' => 'Giochi con Candele',
                ],
                'categorie_id' => $categories['dominatrice-bdsm'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Jeux médicaux',
                    'en-US' => 'Medical Play',
                    'es' => 'Juegos Médicos',
                    'de' => 'Medizinisches Spiel',
                    'it' => 'Giochi Medici',
                ],
                'categorie_id' => $categories['dominatrice-bdsm'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Jeux sexuels',
                    'en-US' => 'Sexual Games',
                    'es' => 'Juegos Sexuales',
                    'de' => 'Sexspiele',
                    'it' => 'Giochi Sessuali',
                ],
                'categorie_id' => $categories['dominatrice-bdsm'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Lavement érotiques',
                    'en-US' => 'Erotic Enema',
                    'es' => 'Enema Erótico',
                    'de' => 'Erotischer Einlauf',
                    'it' => 'Clistere Erotico',
                ],
                'categorie_id' => $categories['dominatrice-bdsm'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Piétinement',
                    'en-US' => 'Trampling',
                    'es' => 'Pisoteo',
                    'de' => 'Trampeln',
                    'it' => 'Calpestamento',
                ],
                'categorie_id' => $categories['dominatrice-bdsm'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Privation d\'orgasme',
                    'en-US' => 'Orgasm Denial',
                    'es' => 'Negación del Orgasmo',
                    'de' => 'Orgasmusverweigerung',
                    'it' => 'Negazione dell\'Orgasmo',
                ],
                'categorie_id' => $categories['dominatrice-bdsm'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Rasage',
                    'en-US' => 'Shaving',
                    'es' => 'Afeitado',
                    'de' => 'Rasieren',
                    'it' => 'Rasatura',
                ],
                'categorie_id' => $categories['dominatrice-bdsm'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Scatophilie',
                    'en-US' => 'Scatophilia',
                    'es' => 'Escatofilia',
                    'de' => 'Skatophilie',
                    'it' => 'Scatofilia',
                ],
                'categorie_id' => $categories['dominatrice-bdsm'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Soumise',
                    'en-US' => 'Submissive',
                    'es' => 'Sumisa',
                    'de' => 'Unterwürfig',
                    'it' => 'Sottomessa',
                ],
                'categorie_id' => $categories['dominatrice-bdsm'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Suspensions',
                    'en-US' => 'Suspensions',
                    'es' => 'Suspensiones',
                    'de' => 'Aufhängungen',
                    'it' => 'Sospensioni',
                ],
                'categorie_id' => $categories['dominatrice-bdsm'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Tortures érotiques',
                    'en-US' => 'Erotic Torture',
                    'es' => 'Tortura Erótica',
                    'de' => 'Erotische Folter',
                    'it' => 'Tortura Erotica',
                ],
                'categorie_id' => $categories['dominatrice-bdsm'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Travestissement',
                    'en-US' => 'Cross-Dressing',
                    'es' => 'Travestismo',
                    'de' => 'Transvestitismus',
                    'it' => 'Travestitismo',
                ],
                'categorie_id' => $categories['dominatrice-bdsm'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Urologie',
                    'en-US' => 'Urology',
                    'es' => 'Urología',
                    'de' => 'Urologie',
                    'it' => 'Urologia',
                ],
                'categorie_id' => $categories['dominatrice-bdsm'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Viol théâtralisé',
                    'en-US' => 'Staged Rape',
                    'es' => 'Violación Escenificada',
                    'de' => 'Inszenierte Vergewaltigung',
                    'it' => 'Stupro Inscenato',
                ],
                'categorie_id' => $categories['dominatrice-bdsm'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Voyeurisme',
                    'en-US' => 'Voyeurism',
                    'es' => 'Voyeurismo',
                    'de' => 'Voyeurismus',
                    'it' => 'Voyeurismo',
                ],
                'categorie_id' => $categories['dominatrice-bdsm'] ?? null,
            ],

            // Services pour la catégorie 'masseuse-no-sex'
            [
                'nom' => [
                    'fr' => 'Drainage lymphatique',
                    'en-US' => 'Lymphatic drainage',
                    'es' => 'Drenaje linfático',
                    'de' => 'Lymphdrainage',
                    'it' => 'Drenaggio linfatico',
                ],
                'categorie_id' => $categories['masseuse-no-sex'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Massage 4 mains',
                    'en-US' => '4 hands massage',
                    'es' => 'Masaje 4 manos',
                    'de' => '4 Hände Massage',
                    'it' => 'Massaggio 4 mani',
                ],
                'categorie_id' => $categories['masseuse-no-sex'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => '69',
                    'en-US' => '69',
                    'es' => '69',
                    'de' => '69',
                    'it' => '69',
                ],
                'categorie_id' => $categories['trans'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Anulingus (actif)',
                    'en-US' => 'Anilingus (active)',
                    'es' => 'Anilingus (activo)',
                    'de' => 'Anilingus (aktiv)',
                    'it' => 'Anilingus (attivo)',
                ],
                'categorie_id' => $categories['trans'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Anulingus (passif)',
                    'en-US' => 'Anilingus (passive)',
                    'es' => 'Anilingus (pasivo)',
                    'de' => 'Anilingus (passiv)',
                    'it' => 'Anilingus (passivo)',
                ],
                'categorie_id' => $categories['trans'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Branlette seins',
                    'en-US' => 'Titjob',
                    'es' => 'Mamada',
                    'de' => 'Tittenfick',
                    'it' => 'Pompino tra i seni',
                ],
                'categorie_id' => $categories['trans'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Café pipe',
                    'en-US' => 'Blowjob with Coffee',
                    'es' => 'Mamada con Café',
                    'de' => 'Blowjob mit Kaffee',
                    'it' => 'Pompino con Caffè',
                ],
                'categorie_id' => $categories['trans'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Champagne doré actif',
                    'en-US' => 'Active Golden Shower',
                    'es' => 'Ducha Dorada Activa',
                    'de' => 'Aktiver Goldener Regen',
                    'it' => 'Doccia Dorata Attiva',
                ],
                'categorie_id' => $categories['trans'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Champagne doré passif',
                    'en-US' => 'Passive Golden Shower',
                    'es' => 'Ducha Dorada Pasiva',
                    'de' => 'Passiver Goldener Regen',
                    'it' => 'Doccia Dorata Passiva',
                ],
                'categorie_id' => $categories['trans'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Couple',
                    'en-US' => 'Couple',
                    'es' => 'Pareja',
                    'de' => 'Paar',
                    'it' => 'Coppia',
                ],
                'categorie_id' => $categories['trans'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Domination soft',
                    'en-US' => 'Soft Domination',
                    'es' => 'Dominación Suave',
                    'de' => 'Sanfte Dominanz',
                    'it' => 'Dominazione Dolce',
                ],
                'categorie_id' => $categories['trans'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Double pénétration',
                    'en-US' => 'Double Penetration',
                    'es' => 'Doble Penetración',
                    'de' => 'Doppelte Penetration',
                    'it' => 'Doppia Penetrazione',
                ],
                'categorie_id' => $categories['trans'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Ejaculation corps',
                    'en-US' => 'Body Ejaculation',
                    'es' => 'Eyaculación Corporal',
                    'de' => 'Körper Ejakulation',
                    'it' => 'Eiaculazione sul Corpo',
                ],
                'categorie_id' => $categories['trans'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Ejaculation faciale',
                    'en-US' => 'Facial Ejaculation',
                    'es' => 'Eyaculación Facial',
                    'de' => 'Gesicht Ejakulation',
                    'it' => 'Eiaculazione sul Viso',
                ],
                'categorie_id' => $categories['trans'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Facesitting',
                    'en-US' => 'Facesitting',
                    'es' => 'Facesitting',
                    'de' => 'Gesichtssitzen',
                    'it' => 'Facesitting',
                ],
                'categorie_id' => $categories['trans'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Fellation',
                    'en-US' => 'Fellatio',
                    'es' => 'Felación',
                    'de' => 'Fellatio',
                    'it' => 'Fellatio',
                ],
                'categorie_id' => $categories['trans'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Fétichisme',
                    'en-US' => 'Fetishism',
                    'es' => 'Fetichismo',
                    'de' => 'Fetischismus',
                    'it' => 'Feticismo',
                ],
                'categorie_id' => $categories['trans'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'French Kiss',
                    'en-US' => 'French Kiss',
                    'es' => 'Beso Francés',
                    'de' => 'Französischer Kuss',
                    'it' => 'Bacio alla Francese',
                ],
                'categorie_id' => $categories['trans'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'GFE',
                    'en-US' => 'Girlfriend Experience',
                    'es' => 'Experiencia de Novia',
                    'de' => 'Freundin-Erlebnis',
                    'it' => 'Esperienza da Fidanzata',
                ],
                'categorie_id' => $categories['trans'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Gorge profonde',
                    'en-US' => 'Deep Throat',
                    'es' => 'Garganta Profunda',
                    'de' => 'Tiefen Kehle',
                    'it' => 'Gola Profonda',
                ],
                'categorie_id' => $categories['trans'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Jeux de rôles',
                    'en-US' => 'Role Playing',
                    'es' => 'Juegos de Rol',
                    'de' => 'Rollenspiele',
                    'it' => 'Giochi di Ruolo',
                ],
                'categorie_id' => $categories['trans'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Lingerie',
                    'en-US' => 'Lingerie',
                    'es' => 'Lencería',
                    'de' => 'Dessous',
                    'it' => 'Biancheria Intima',
                ],
                'categorie_id' => $categories['trans'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Massage érotique',
                    'en-US' => 'Erotic Massage',
                    'es' => 'Masaje Erótico',
                    'de' => 'Erotische Massage',
                    'it' => 'Massaggio Erotico',
                ],
                'categorie_id' => $categories['trans'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Masturbation',
                    'en-US' => 'Masturbation',
                    'es' => 'Masturbación',
                    'de' => 'Masturbation',
                    'it' => 'Masturbazione',
                ],
                'categorie_id' => $categories['trans'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Porn Star Experience',
                    'en-US' => 'Porn Star Experience',
                    'es' => 'Experiencia Estrella Porno',
                    'de' => 'Pornostar-Erlebnis',
                    'it' => 'Esperienza da Star del Porno',
                ],
                'categorie_id' => $categories['trans'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Rapport Sexuel',
                    'en-US' => 'Sexual Intercourse',
                    'es' => 'Relación Sexual',
                    'de' => 'Geschlechtsverkehr',
                    'it' => 'Rapporto Sessuale',
                ],
                'categorie_id' => $categories['trans'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Service VIP',
                    'en-US' => 'VIP Service',
                    'es' => 'Servicio VIP',
                    'de' => 'VIP-Service',
                    'it' => 'Servizio VIP',
                ],
                'categorie_id' => $categories['trans'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Sexe de Groupe (orgie)',
                    'en-US' => 'Group Sex (Orgy)',
                    'es' => 'Sexo en Grupo (Orgía)',
                    'de' => 'Gruppensex (Orgie)',
                    'it' => 'Sesso di Gruppo (Orgia)',
                ],
                'categorie_id' => $categories['trans'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Sex Toys',
                    'en-US' => 'Sex Toys',
                    'es' => 'Juguetes Sexuales',
                    'de' => 'Sexspielzeug',
                    'it' => 'Sex Toys',
                ],
                'categorie_id' => $categories['trans'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Sodomie (active)',
                    'en-US' => 'Anal Sex (Active)',
                    'es' => 'Sexo Anal (Activo)',
                    'de' => 'Analverkehr (Aktiv)',
                    'it' => 'Sesso Anale (Attivo)',
                ],
                'categorie_id' => $categories['trans'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Sodomie (passive)',
                    'en-US' => 'Anal Sex (Passive)',
                    'es' => 'Sexo Anal (Pasivo)',
                    'de' => 'Analverkehr (Passiv)',
                    'it' => 'Sesso Anale (Passivo)',
                ],
                'categorie_id' => $categories['trans'] ?? null,
            ],
            [
                'nom' => [
                    'fr' => 'Striptease',
                    'en-US' => 'Striptease',
                    'es' => 'Striptease',
                    'de' => 'Striptease',
                    'it' => 'Spogliarello',
                ],
                'categorie_id' => $categories['trans'] ?? null,
            ],
        ];

        // Création des services avec leurs traductions
        foreach ($services as $serviceData) {
            $service = new Service();
            foreach ($serviceData['nom'] as $locale => $translation) {
                $service->setTranslation('nom', $locale, $translation);
            }
            $service->categorie_id = $serviceData['categorie_id'];
            $service->save();
        }

        // DB::table('services')->insert([
        //     ['nom' => '69', 'categorie_id' => $categories['escort'] ?? null],
        //     ['nom' => 'Anulingus (actif)', 'categorie_id' => $categories['escort'] ?? null],
        //     ['nom' => 'Anulingus (passif)', 'categorie_id' => $categories['escort'] ?? null],
        //     ['nom' => 'Branlette seins', 'categorie_id' => $categories['escort'] ?? null],
        //     ['nom' => 'Café Pipe', 'categorie_id' => $categories['escort'] ?? null],
        //     ['nom' => 'Champagne doré actif', 'categorie_id' => $categories['escort'] ?? null],
        //     ['nom' => 'Champagne doré passif', 'categorie_id' => $categories['escort'] ?? null],
        //     ['nom' => 'Couple', 'categorie_id' => $categories['escort'] ?? null],
        //     ['nom' => 'Cunnilingus', 'categorie_id' => $categories['escort'] ?? null],
        //     ['nom' => 'Doigté anal', 'categorie_id' => $categories['escort'] ?? null],
        //     ['nom' => 'Doigté vaginal', 'categorie_id' => $categories['escort'] ?? null],
        //     ['nom' => 'Domination soft', 'categorie_id' => $categories['escort'] ?? null],
        //     ['nom' => 'Double pénétration', 'categorie_id' => $categories['escort'] ?? null],
        //     ['nom' => 'Duo', 'categorie_id' => $categories['escort'] ?? null],

        //     ['nom' => 'Ejaculation corps', 'categorie_id' => $categories['escort'] ?? null],
        //     ['nom' => 'Ejaculation faciale', 'categorie_id' => $categories['escort'] ?? null],
        //     ['nom' => 'Ejaculation multiple OK', 'categorie_id' => $categories['escort'] ?? null],
        //     ['nom' => 'Facesitting', 'categorie_id' => $categories['escort'] ?? null],
        //     ['nom' => 'Femme Fontaine', 'categorie_id' => $categories['escort'] ?? null],
        //     ['nom' => 'Fessées Acceptées', 'categorie_id' => $categories['escort'] ?? null],
        //     ['nom' => 'Fétichisme', 'categorie_id' => $categories['escort'] ?? null],
        //     ['nom' => 'French Kiss', 'categorie_id' => $categories['escort'] ?? null],
        //     ['nom' => 'GFE', 'categorie_id' => $categories['escort'] ?? null],
        //     ['nom' => 'Gorge Profonde', 'categorie_id' => $categories['escort'] ?? null],
        //     ['nom' => 'Jeux de rôles', 'categorie_id' => $categories['escort'] ?? null],
        //     ['nom' => 'Lingerie', 'categorie_id' => $categories['escort'] ?? null],
        //     ['nom' => 'Massage érotique', 'categorie_id' => $categories['escort'] ?? null],
        //     ['nom' => 'Masturbation', 'categorie_id' => $categories['escort'] ?? null],
        //     ['nom' => 'Porn Star Experience', 'categorie_id' => $categories['escort'] ?? null],
        //     ['nom' => 'Rapport Sexuel', 'categorie_id' => $categories['escort'] ?? null],
        //     ['nom' => 'Service VIP', 'categorie_id' => $categories['escort'] ?? null],
        //     ['nom' => 'Sexe de groupe (orgie)', 'categorie_id' => $categories['escort'] ?? null],
        //     ['nom' => 'Sex Toys', 'categorie_id' => $categories['escort'] ?? null],
        //     ['nom' => 'Sodomie (active)', 'categorie_id' => $categories['escort'] ?? null],
        //     ['nom' => 'Sodomie (passive)', 'categorie_id' => $categories['escort'] ?? null],
        //     ['nom' => 'Soumise', 'categorie_id' => $categories['escort'] ?? null],
        //     ['nom' => 'Stripteas', 'categorie_id' => $categories['escort'] ?? null],

        //     ['nom' => 'Drainage lymphatique', 'categorie_id' => $categories['masseuse-no-sex'] ?? null],
        //     ['nom' => 'Massage 4 mains', 'categorie_id' => $categories['masseuse-no-sex'] ?? null],
        //     ['nom' => 'Massage 6 mains', 'categorie_id' => $categories['masseuse-no-sex'] ?? null],
        //     ['nom' => 'Massage abdominal', 'categorie_id' => $categories['masseuse-no-sex'] ?? null],
        //     ['nom' => 'Massage antistress', 'categorie_id' => $categories['masseuse-no-sex'] ?? null],
        //     ['nom' => 'Massage Australien', 'categorie_id' => $categories['masseuse-no-sex'] ?? null],
        //     ['nom' => 'Massage aux huiles', 'categorie_id' => $categories['masseuse-no-sex'] ?? null],
        //     ['nom' => 'Massage ayurvédique', 'categorie_id' => $categories['masseuse-no-sex'] ?? null],
        //     ['nom' => 'Massage body body', 'categorie_id' => $categories['masseuse-no-sex'] ?? null],
        //     ['nom' => 'Massage californien', 'categorie_id' => $categories['masseuse-no-sex'] ?? null],
        //     ['nom' => 'Massage douche', 'categorie_id' => $categories['masseuse-no-sex'] ?? null],
        //     ['nom' => 'Massage en Couple', 'categorie_id' => $categories['masseuse-no-sex'] ?? null],
        //     ['nom' => 'Massage Jacuzzi', 'categorie_id' => $categories['masseuse-no-sex'] ?? null],
        //     ['nom' => 'Massage Naturiste', 'categorie_id' => $categories['masseuse-no-sex'] ?? null],
        //     ['nom' => 'Massage oriental', 'categorie_id' => $categories['masseuse-no-sex'] ?? null],
        //     ['nom' => 'Massage prostate', 'categorie_id' => $categories['masseuse-no-sex'] ?? null],
        //     ['nom' => 'Massage Réciproque', 'categorie_id' => $categories['masseuse-no-sex'] ?? null],
        //     ['nom' => 'Massage Shiatsu', 'categorie_id' => $categories['masseuse-no-sex'] ?? null],
        //     ['nom' => 'Massage Suédois', 'categorie_id' => $categories['masseuse-no-sex'] ?? null],
        //     ['nom' => 'Massage tantra', 'categorie_id' => $categories['masseuse-no-sex'] ?? null],
        //     ['nom' => 'Massage thaïlandais', 'categorie_id' => $categories['masseuse-no-sex'] ?? null],
        //     ['nom' => 'Séance Hydromassage', 'categorie_id' => $categories['masseuse-no-sex'] ?? null],

        //     ['nom' => 'Asphyxie érotique', 'categorie_id' => $categories['dominatrice-bdsm'] ?? null],
        //     ['nom' => 'Ballbusting', 'categorie_id' => $categories['dominatrice-bdsm'] ?? null],
        //     ['nom' => 'Bondage', 'categorie_id' => $categories['dominatrice-bdsm'] ?? null],
        //     ['nom' => 'Camisoles', 'categorie_id' => $categories['dominatrice-bdsm'] ?? null],
        //     ['nom' => 'Caviar actif', 'categorie_id' => $categories['dominatrice-bdsm'] ?? null],
        //     ['nom' => 'Caviar passif', 'categorie_id' => $categories['dominatrice-bdsm'] ?? null],
        //     ['nom' => 'Champagne doré actif', 'categorie_id' => $categories['dominatrice-bdsm'] ?? null],
        //     ['nom' => 'Champagne doré passif', 'categorie_id' => $categories['dominatrice-bdsm'] ?? null],
        //     ['nom' => 'Chantage', 'categorie_id' => $categories['dominatrice-bdsm'] ?? null],
        //     ['nom' => 'Domination hard', 'categorie_id' => $categories['dominatrice-bdsm'] ?? null],
        //     ['nom' => 'Electro stimulation', 'categorie_id' => $categories['dominatrice-bdsm'] ?? null],
        //     ['nom' => 'Enfermement', 'categorie_id' => $categories['dominatrice-bdsm'] ?? null],
        //     ['nom' => 'Etranglement', 'categorie_id' => $categories['dominatrice-bdsm'] ?? null],
        //     ['nom' => 'Exhibition', 'categorie_id' => $categories['dominatrice-bdsm'] ?? null],
        //     ['nom' => 'Facesitting', 'categorie_id' => $categories['dominatrice-bdsm'] ?? null],
        //     ['nom' => 'Féminisation', 'categorie_id' => $categories['dominatrice-bdsm'] ?? null],
        //     ['nom' => 'Fessée active', 'categorie_id' => $categories['dominatrice-bdsm'] ?? null],
        //     ['nom' => 'Fessée passive', 'categorie_id' => $categories['dominatrice-bdsm'] ?? null],
        //     ['nom' => 'Fétichisme', 'categorie_id' => $categories['dominatrice-bdsm'] ?? null],
        //     ['nom' => 'Fisting actif', 'categorie_id' => $categories['dominatrice-bdsm'] ?? null],
        //     ['nom' => 'Fisting passif', 'categorie_id' => $categories['dominatrice-bdsm'] ?? null],
        //     ['nom' => 'Humiliations', 'categorie_id' => $categories['dominatrice-bdsm'] ?? null],
        //     ['nom' => 'Jeux de bougie', 'categorie_id' => $categories['dominatrice-bdsm'] ?? null],
        //     ['nom' => 'Jeux médicaux', 'categorie_id' => $categories['dominatrice-bdsm'] ?? null],
        //     ['nom' => 'Jeux sexuels', 'categorie_id' => $categories['dominatrice-bdsm'] ?? null],
        //     ['nom' => 'Lavement érotiques', 'categorie_id' => $categories['dominatrice-bdsm'] ?? null],
        //     ['nom' => 'Piétinement', 'categorie_id' => $categories['dominatrice-bdsm'] ?? null],
        //     ['nom' => 'Privation d’orgasme', 'categorie_id' => $categories['dominatrice-bdsm'] ?? null],
        //     ['nom' => 'Rasage', 'categorie_id' => $categories['dominatrice-bdsm'] ?? null],
        //     ['nom' => 'Scatophilie', 'categorie_id' => $categories['dominatrice-bdsm'] ?? null],
        //     ['nom' => 'Soumise', 'categorie_id' => $categories['dominatrice-bdsm'] ?? null],
        //     ['nom' => 'Suspensions', 'categorie_id' => $categories['dominatrice-bdsm'] ?? null],
        //     ['nom' => 'Tortures érotiques', 'categorie_id' => $categories['dominatrice-bdsm'] ?? null],
        //     ['nom' => 'Travestissement', 'categorie_id' => $categories['dominatrice-bdsm'] ?? null],
        //     ['nom' => 'Urologie', 'categorie_id' => $categories['dominatrice-bdsm'] ?? null],
        //     ['nom' => 'Viol théâtralisé', 'categorie_id' => $categories['dominatrice-bdsm'] ?? null],
        //     ['nom' => 'Voyeurisme', 'categorie_id' => $categories['dominatrice-bdsm'] ?? null],

        //     ['nom' => '69', 'categorie_id' => $categories['trans'] ?? null],
        //     ['nom' => 'Anulingus (actif)', 'categorie_id' => $categories['trans'] ?? null],
        //     ['nom' => 'Anulingus (passif)', 'categorie_id' => $categories['trans'] ?? null],
        //     ['nom' => 'Branlette seins', 'categorie_id' => $categories['trans'] ?? null],
        //     ['nom' => 'Café pipe', 'categorie_id' => $categories['trans'] ?? null],
        //     ['nom' => 'Champagne doré actif', 'categorie_id' => $categories['trans'] ?? null],
        //     ['nom' => 'Champagne doré passif', 'categorie_id' => $categories['trans'] ?? null],
        //     ['nom' => 'Couple', 'categorie_id' => $categories['trans'] ?? null],
        //     ['nom' => 'Domination soft', 'categorie_id' => $categories['trans'] ?? null],
        //     ['nom' => 'Double pénétration', 'categorie_id' => $categories['trans'] ?? null],
        //     ['nom' => 'Ejaculation corps', 'categorie_id' => $categories['trans'] ?? null],
        //     ['nom' => 'Ejaculation faciale', 'categorie_id' => $categories['trans'] ?? null],
        //     ['nom' => 'Facesitting', 'categorie_id' => $categories['trans'] ?? null],
        //     ['nom' => 'Fellation', 'categorie_id' => $categories['trans'] ?? null],
        //     ['nom' => 'Fétichisme', 'categorie_id' => $categories['trans'] ?? null],
        //     ['nom' => 'French Kiss', 'categorie_id' => $categories['trans'] ?? null],
        //     ['nom' => 'GFE', 'categorie_id' => $categories['trans'] ?? null],
        //     ['nom' => 'Gorge profonde', 'categorie_id' => $categories['trans'] ?? null],
        //     ['nom' => 'Jeux de rôles', 'categorie_id' => $categories['trans'] ?? null],
        //     ['nom' => 'Lingerie', 'categorie_id' => $categories['trans'] ?? null],
        //     ['nom' => 'Massage érotique', 'categorie_id' => $categories['trans'] ?? null],
        //     ['nom' => 'Masturbation', 'categorie_id' => $categories['trans'] ?? null],
        //     ['nom' => 'Porn Star Experience', 'categorie_id' => $categories['trans'] ?? null],
        //     ['nom' => 'Rapport Sexuel', 'categorie_id' => $categories['trans'] ?? null],
        //     ['nom' => 'Service VIP', 'categorie_id' => $categories['trans'] ?? null],
        //     ['nom' => 'Sexe de Groupe (orgie)', 'categorie_id' => $categories['trans'] ?? null],
        //     ['nom' => 'Sex Toys', 'categorie_id' => $categories['trans'] ?? null],
        //     ['nom' => 'Sodomie (active)', 'categorie_id' => $categories['trans'] ?? null],
        //     ['nom' => 'Sodomie (passive)', 'categorie_id' => $categories['trans'] ?? null],
        //     ['nom' => 'Striptease', 'categorie_id' => $categories['trans'] ?? null],
        // ]);
    }
}
