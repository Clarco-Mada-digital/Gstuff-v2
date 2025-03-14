@extends('layouts.base')
  @section('content')

  @section('extraStyle')
    <style>
      h3{
        font-family: 'DM serif';
        font-size: 30px;
        font-weight: bold;
        margin: 10px 0;
      }
      .content a{
        color: var(--color-green-gs);
      }
      .content a:hover{
        color: #e9d168;
      }
    </style>
  @endsection

  <div class="w-full bg-green-gs/50 py-10 content" style="background: url('images/Fond-page-politique.jpg') center center /cover">
    <div class="w-full lg:w-[70%] lg:mx-auto p-5 bg-white">
      <h2 class="text-5xl font-dm-serif font-bold text-green-gs text-center py-2 shadow-lg w-full">Politique de confidentialité</h2>
      <h3>Qui nous sommes</h3>
      <p>Notre adresse de site Web est: <a href="{{ url('home') }}">https://gstuff.ch</a></p>

      <h3>Commentaires</h3>
      <p>Lorsque les visiteurs laissent des commentaires sur le site, nous collectons les données affichées dans le formulaire de commentaires, ainsi que l’adresse IP du visiteur et la chaîne d’agent utilisateur du navigateur pour aider à la détection du spam.</p>

      <p>Une chaîne anonymisée créée à partir de votre adresse e-mail (également appelée hachage) peut être fournie au service Gravatar pour voir si vous l’utilisez. La politique de confidentialité du service Gravatar est disponible ici: <a href="https://automattic.com/privacy/">https://automattic.com/privacy/</a>. Après l’approbation de votre commentaire, votre photo de profil est visible par le public dans le contexte de votre commentaire.</p>

      <h3>Médias</h3>
      <p>Si vous téléchargez des images sur le site Web, vous devez éviter de télécharger des images avec des données de localisation intégrées (EXIF GPS) incluses. Les visiteurs du site Web peuvent télécharger et extraire toutes les données de localisation à partir d’images sur le site Web.</p>

      <h3>Cookies</h3>
      <p>Si vous laissez un commentaire sur notre site, vous pouvez opter pour enregistrer votre nom, votre adresse e-mail et votre site Web dans les cookies. Ce sont pour votre commodité afin que vous n’ayez plus à remplir vos coordonnées lorsque vous quittez un autre commentaire. Ces cookies dureront un an</p>.

      <p>Si vous visitez notre page de connexion, nous définirons un cookie temporaire pour déterminer si votre navigateur accepte les cookies. Ce cookie ne contient pas de données personnelles et est rejetée lorsque vous fermez votre navigateur.</p>

      <p>Lorsque vous vous connectez, nous configurerons également plusieurs cookies pour enregistrer vos informations de connexion et vos choix d’affichage d’écran. Les cookies de connexion durent deux jours et les cookies des options d’écran durent un an. Si vous sélectionnez « Remember Me », votre connexion persistera pendant deux semaines. Si vous vous déconnectez de votre compte, les cookies de connexion seront supprimés.</p>

      <p>Si vous modifiez ou publiez un article, un cookie supplémentaire sera enregistré dans votre navigateur. Ce cookie ne comprend pas de données personnelles et indique simplement la publication de l’article que vous venez de modifier. Il expire après 1 jour.</p>

      <h3>Contenu intégré à partir d’autres sites Web</h3>
      <p>Les articles de ce site peuvent inclure du contenu intégré (par exemple, des vidéos, des images, des articles, etc.). Le contenu intégré d’autres sites Web se comporte exactement de la même manière que si le visiteur avait visité l’autre site Web.</p>


      <p>Ces sites Web peuvent collecter des données vous concernant, utiliser des cookies, intégrer un suivi tiers supplémentaire et surveiller votre interaction avec ce contenu intégré, y compris le suivi de votre interaction avec le contenu intégré si vous avez un compte et que vous êtes connecté à ce site Web.</p>

      <h3>Avec qui partageons-nous vos données ?</h3>
      <p>Si vous demandez une réinitialisation du mot de passe, votre adresse IP sera incluse dans l’e-mail de réinitialisation.</p>

      <h3>Combien de temps conservons-nous vos données ?</h3>
      <p>Si vous laissez un commentaire, le commentaire et ses métadonnées sont conservés indéfiniment. Cela nous permet de reconnaître et d’approuver automatiquement tous les commentaires de suivi au lieu de les conserver dans une file d’attente de modération.</p>


      <p>Pour les utilisateurs qui s’inscrivent sur notre site Web (le cas échéant), nous stockons également les informations personnelles qu’ils fournissent dans leur profil d’utilisateur. Tous les utilisateurs peuvent voir, modifier ou supprimer leurs informations personnelles à tout moment (sauf qu’ils ne peuvent pas changer leur nom d’utilisateur). Les administrateurs du site Web peuvent également voir et modifier ces informations.</p>

      <h3>Quels sont vos droits sur vos données ?</h3>
      <p>Si vous avez un compte sur ce site, ou si vous avez laissé des commentaires, vous pouvez demander à recevoir un fichier exporté des données personnelles que nous détenons à votre sujet, y compris les données que vous nous avez fournies. Vous pouvez également nous demander d’effacer toutes les données personnelles que nous détenons à votre sujet. Cela n’inclut pas les données que nous sommes tenus de conserver à des fins administratives, juridiques ou de sécurité.</p>

      <h3>Où vos données sont-elles envoyées ?</h3>
      <p>Les commentaires des visiteurs peuvent être vérifiés par le biais d’un service automatisé de détection des spams.</p>

    </div>
  </div>

  @stop
