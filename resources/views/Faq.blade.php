@extends('layouts.base')
  @section('content')

  <div class="bg-green-gs/30 flex items-center justify-center min-h-60 py-20">
    <h2 class="font-dm-serif font-bold text-3xl lg:text-5xl text-green-gs text-center">Foires Aux Questions</h2>
  </div>
  <div class="xl:container px-10 xl:px-60 mx-auto my-10 py-15">
    <div id="accordion-collapse text-wrap" data-accordion="collapse">
      <h2 id="accordion-collapse-heading-1" class="w-full">
        <button type="button" class="flex items-center justify-between w-full p-5 font-dm-serif font-bold text-2xl rtl:text-right text-green-gs border border-b-0 rounded-t-xl hover:text-white hover:bg-green-gs dark:hover:bg-green-gs gap-3 bg-green-gs/30" data-accordion-target="#accordion-collapse-body-1" aria-expanded="true" aria-controls="accordion-collapse-body-1">
          <span class="flex items-center"><svg class="w-5 h-5 me-2 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg>Qu'est-ce que Gstuff.ch ?</span>
          <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
          </svg>
        </button>
      </h2>
      <div id="accordion-collapse-body-1" class="hidden" aria-labelledby="accordion-collapse-heading-1">
        <div class="p-5 border border-b-0 border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900">
          <p class="mb-2">Gstuff.ch est un site suisse d’annonces érotiques. Il répertorie des travailleurs et travailleuses du sexe exerçant leur activité en Suisse.

            Il permet aux annonceurs de trouver une visibilité certaine auprès d’un public ouvert et respectueux. Il permet à chacun et chacune de naviguer sur le site et de trouver réponse à ses fantasmes. Gstuff se veut inclusif et dans ce sens, seul le plaisir compte.

            Naviguer sur Gstuff, c’est aussi n’avoir besoin que d’une seule ressource pour trouver tout ce qui attrait à la sexualité. Vous trouverez naturellement diverses informations en lien avec les services sexuels, mais également de l’information sur l’actualité érotique suisse, des liens utiles vers diverses administrations et un soutien par des professionnels de la sexologie si besoin.</p>
        </div>
      </div>
      <h2 id="accordion-collapse-heading-2" class="w-full">
        <button type="button" class="flex items-center justify-between w-full p-5 font-dm-serif font-bold text-2xl rtl:text-right text-green-gs border border-b-0 hover:text-white hover:bg-green-gs dark:hover:bg-green-gs gap-3 bg-green-gs/30" data-accordion-target="#accordion-collapse-body-2" aria-expanded="false" aria-controls="accordion-collapse-body-2">
          <span class="flex items-center"><svg class="w-5 h-5 me-2 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg>Quels sont les avantages de s'inscrire sur Gstuff ?</span>
          <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
          </svg>
        </button>
      </h2>
      <div id="accordion-collapse-body-2" class="hidden" aria-labelledby="accordion-collapse-heading-2">
        <div class="p-5 border border-b-0 border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900">
          <ul class="mb-2">
            <li>• S’assurer une visibilité auprès du public vivant ou de passage en Suisse</li>
            <li>• Une utilisation facile et intuitive</li>
            <li>• Bénéficier d’informations régulièrement mises à jour</li>
            <li>• Bénéficier de l’expertise de professionnels dans le champ de la sexualité et de leur soutien si besoin</li>
            <li>• Utiliser une plateforme dont les utilisateurs sont ouverts et respectueux</li>

          </ul>
          <p>Pour résumer, Gstuff.ch c’est la garantie d’une plateforme qui marque sa différence non seulement par son apparence, mais aussi par la simplicité de son utilisation et la qualité des informations qui y figurent.</p>
        </div>
      </div>
      <h2 id="accordion-collapse-heading-3" class="w-full">
        <button type="button" class="flex items-center justify-between w-full p-5 font-dm-serif font-bold text-2xl rtl:text-right text-green-gs border border-b-0 hover:text-white hover:bg-green-gs dark:hover:bg-green-gs gap-3 bg-green-gs/30" data-accordion-target="#accordion-collapse-body-3" aria-expanded="false" aria-controls="accordion-collapse-body-3">
          <span class="flex items-center"><svg class="w-5 h-5 me-2 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg>Quelles sont les 3 conditions requises pour s'inscrire sur Gstuff ?</span>
          <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
          </svg>
        </button>
      </h2>
      <div id="accordion-collapse-body-3" class="hidden" aria-labelledby="accordion-collapse-heading-2">
        <div class="p-5 border border-b-0 flex flex-col gap-2 border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900">
          <b>Être majeur/e :</b>

          <p>Pour visiter le site, vous devez avoir l’âge légal pour le faire. En Suisse, il vous faut avoir 18 ans révolus pour naviguer sur Gstuff. De même donc pour vous créer un profil ou passer une annonce, vous devez être majeur/e. Ceci est la seule condition si vous ne publiez pas d’annonce.</p>

          <p>A noter qu’il vous faut ne pas être sous tutelle ou curatelle également.</p>

          <p>Dans le cas où vous désirez publier une annonce à caractère érotique sur notre plateforme, il vous faut remplir les deux conditions suivantes :</p>

          <b>Travailler en Suisse :</b>
          <p>En effet, Gstuff est un site 100% Suisse. Seules les personnes proposant leurs services en Suisse peuvent publier une annonce sur Gstuff. Vous constaterez que seuls les cantons et villes suisses sont disponibles, lors de la création de votre profil.</p>

          <p>Posséder un numéro de téléphone suisse, que le téléphone soit mobile ou fixe. </p>
        </div>
      </div>
      <h2 id="accordion-collapse-heading-4" class="w-full">
        <button type="button" class="flex items-center justify-between w-full p-5 font-dm-serif font-bold text-2xl rtl:text-right text-green-gs border border-b-0 hover:text-white hover:bg-green-gs dark:hover:bg-green-gs gap-3 bg-green-gs/30" data-accordion-target="#accordion-collapse-body-4" aria-expanded="false" aria-controls="accordion-collapse-body-4">
          <span class="flex items-center"><svg class="w-5 h-5 me-2 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg>Quels sont les moyens de paiement pour valider et publier votre annonce ?</span>
          <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
          </svg>
        </button>
      </h2>
      <div id="accordion-collapse-body-4" class="hidden" aria-labelledby="accordion-collapse-heading-2">
        <div class="p-5 border border-b-0 flex flex-col gap-2 border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900">
          <p>Sur Gstuff, vous pouvez choisir de : </p>
          <p>Payer en ligne, de manière sécurisée ; la validation est alors instantanée.</p>
          <p>Payer en cash ; la validation se fait au moment du rendez-vous en présentiel.</p>
          <p>En cas de difficulté ou pour toute situation particulière, vous pouvez contacter le support à info@gstuff.ch</p>
          <p>Nous vous aiderons à trouver une solution adéquate. </p>
        </div>
      </div>
      <h2 id="accordion-collapse-heading-5" class="w-full">
        <button type="button" class="flex items-center justify-between w-full p-5 font-dm-serif font-bold text-2xl rtl:text-right text-green-gs border border-b-0 hover:text-white hover:bg-green-gs dark:hover:bg-green-gs gap-3 bg-green-gs/30" data-accordion-target="#accordion-collapse-body-5" aria-expanded="false" aria-controls="accordion-collapse-body-5">
          <span class="flex items-center"><svg class="w-5 h-5 me-2 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg>Comment désactiver mon profil pendant mon absence ?</span>
          <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
          </svg>
        </button>
      </h2>
      <div id="accordion-collapse-body-5" class="hidden" aria-labelledby="accordion-collapse-heading-2">
        <div class="p-5 border border-b-0 flex flex-col gap-2 border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900">
          <p>Lorsque vous louez un espace sur Gstuff pour y faire figurer votre annonce, vous vous acquittez du montant correspondant au service souhaité. Par exemple, vous louez un espace pour un mois et vous vous payez le service pour un mois.</p>

          <p>Mais <b>pourquoi payer lors d’une absence ?</b> Gstuff a à coeur que vous puissiez profiter au maximum des prestations proposées, c’est pourquoi, lorsque vous vous absentez, pour partir en vacances, prendre un peu de repos, ou pour toute autre raison vous appartenant, vous pouvez mettre votre profil en pause et ainsi réellement profiter de tout le temps acheté.</p>

          <p>Lors de votre départ :</p>

          <p>Pour ce faire, il faut vous connecter et aller sur votre page de profil, puis sélectionner « Je mets mon profil en pause ». Dès lors, votre profil sera toujours visible par les utilisateurs, mais votre numéro de téléphone sera invisible afin que vous ne soyez pas dérangée.</p>

          <p>A votre retour :</p>

          <p>Dès votre retour, vous pourrez à nouveau vous connecter à votre profil et sélectionner « Je réactive mon profil ». A ce moment-là, votre profil sera à nouveau visible en clair et les informations de contact seront à nouveau visibles pour les utilisateurs qui pourront alors vous contacter sans attendre.</p>
        </div>
      </div>
      <h2 id="accordion-collapse-heading-6" class="w-full">
        <button type="button" class="flex items-center justify-between w-full p-5 font-dm-serif font-bold text-2xl rtl:text-right text-green-gs border border-b-0 hover:text-white hover:bg-green-gs dark:hover:bg-green-gs gap-3 bg-green-gs/30" data-accordion-target="#accordion-collapse-body-6" aria-expanded="false" aria-controls="accordion-collapse-body-6">
          <span class="flex items-center"><svg class="w-5 h-5 me-2 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg>Besoin d'aide ? Contacts utiles</span>
          <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
          </svg>
        </button>
      </h2>
      <div id="accordion-collapse-body-6" class="hidden border-b border-gray-300" aria-labelledby="accordion-collapse-heading-2">
        <div class="p-5 border border-b-0 flex flex-col gap-2 border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900">
          <p>Gstuff vous fournit ci-dessous les adresses utiles pour plusieurs types de requêtes, sans que cela soit exhaustif. Si vous avez une requête spécifique et que vous ne trouvez pas la réponse ci-dessous, contactez-nous à info@gstuff.ch et nous nous ferons un plaisir de chercher le bon interlocuteur pour vous.</p>
          <p>La brigade des mœurs traite les délits à caractère sexuel (viol, contrainte sexuelle, acte d’ordre sexuel avec des enfants ou des personnes incapables de discernement ou de résistance, pornographie interdite et exhibitionnisme). En l’absence du lien direct vers ce service, vous pouvez vous adresser au poste de la police cantonale du canton concerné (liste ci-dessous).</p>
          <p>NB : l’indicatif téléphonique pour les appels vers les numéros suisses (mobiles et fixes) est : 0041 ou +41, suivi du numéro de téléphone à 9 chiffres.</p>
          <p>Exemple : 079 123 45 67 donnera <a href="tel:0041 79 123 45 67">0041 79 123 45 67</a> ou <a href="tel:+41 79 123 45 67">+41 79 123 45 67</a></p><br>
          <p>Pour la Suisse Romande, en plus des liens ci-dessus, les adresses suivantes pourraient vous intéresser :</p>
          <p>Aides sociales et Formations <br>
            Aspasie – Association en faveur des professionnels (les) du sexe – Genève – <a href="www.apasie.ch">www.apasie.ch</a> </p>

            <p>Astrée – Association de Soutien aux Victimes de Traite et d’Exploitation <a href="www.astree.ch">www.astree.ch</a>
            </p>
            <p>ProCore – Réseau Suisse d’Organisations qui défendent les intérêts des travailleuses et travailleurs du sexe <a href="https://procore-info.ch">https://procore-info.ch</a></p>

            <p>Tandem – Association pour l’aide aux personnes en difficulté, marginalisées, toxicodépendantes, prostituées <a href="www.tandem91.org">www.tandem91.org</a> </p>

            <p>Point d’Appui – Espace Multiculturel des Eglises <a href="www.eglisemigrationvd.com">www.eglisemigrationvd.com</a></p>

            <p>Centre LAVI – Association pour les Victimes d’actes de violence – Tél <a href="tel:021 631 03 00">021 631 03 00</a> </p>

            <p>Association Appartenances – Accueil, information et formation pour les personnes migrantes <a href="www.appartenances.ch">www.appartenances.ch</a> </p>

            <p>Fondation ABS – Association d’aide aux personnes toxicodépendantes – <a href="www.fondationabs.ch">www.fondationabs.ch</a></p>

            <p>Caritas – Soutien social Lausanne <a href="www.caritas-vaud.ch">www.caritas-vaud.ch</a> Tél <a href="tel:021 622 06 22"> 021 622 06 22</a> </p>

            <p>Point D’eau Lausanne – Espace de soins et d’orientation <a href="www.pointdeau-lausanne.ch">www.pointdeau-lausanne.ch</a> </p>

            <p>Appartenances Centre Femmes – Cours de français pour les femmes non francophones www.appartenances.ch Tél <a href="tel:021 351 28 80">021 351 28 80</a> </p>

            <p>Bourse à Travail – Centre de formation pour personnes en situation précaire et/ou migrantes <a href="www.labourseatravail.ch">www.labourseatravail.ch</a> </p>

            <p><b>Service Juridiques</b>
              <p>CEDRE</p>
              <p>SAJE – Service d’Aide Juridique aux Exilé-e-s Tél : <a href="tel:021 351 25 51">021 351 25 51</a> </p>

            <p>Centre Social Protestant FRAT – Service social actif dans le domaine de la migration <a href="www.csp.ch">www.csp.ch</a></p>

            <p>Services médicaux et consultations <br>
              CHUV – Centre Hospitalier Universitaire Vaudois Tél. N° <a href="tel:021 314 1 .11">021 314 1 .11</a> <br>
              Maternité Tél <a href="tel:021 314 35 18"> 021 314 35 18</a> <br>
              Urgence Maternité Tél <a href="tel:021 314 34 10">021 314 34 10</a> <br>
              Rendez-Vous gynécologiques <a href="tel:021 314 32 45">021 314 32 45</a> </p>

            <p>PMU – Polyclinique Médicale Universitaire –<a href="www.pmu-lausanne.ch">www.pmu-lausanne.ch</a> <a href="tel:Tél 021 314 60 60">Tél 021 314 60 60</a>
              Consultation VIH/IST / Tests Anonymes <a href="tel:021 314 49 17">Tél 021 314 49 17</a>
              Permanences Flon <a href="tel:021 314 90 90">Tél 021 314 90 90</a></p>

            <p> Profa – Consultation de Santé Sexuelle / Planning Familial <a href="www.profa.ch">www.profa.ch</a></p>

            <p>AIDS – Aide Suisse Contre le Sida – <a href="www.aids.ch">www.aids.ch</a></p>
          </p>

        </div>
      </div>
    </div>

  </div>

  <x-CallToActionContact />

  @stop
