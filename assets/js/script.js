document.addEventListener('DOMContentLoaded', () => {

    // ==========================================
    // 1. LOGIQUE DU LOGIN / INSCRIPTION (Panel Slide)
    // ==========================================
    const signUpBtn = document.getElementById('signUp');
    const signInBtn = document.getElementById('signIn');
    const container = document.getElementById('login-container');

    if (signUpBtn && signInBtn && container) {
        signUpBtn.addEventListener('click', () => container.classList.add("right-panel-active"));
        signInBtn.addEventListener('click', () => container.classList.remove("right-panel-active"));
    }


    // ==========================================
    // 2. MENU BURGER MOBILE
    // ==========================================
    const burger = document.getElementById('burger');
    const navLinks = document.getElementById('nav-links');
    
    if (burger && navLinks) {
        burger.addEventListener('click', () => {
            burger.classList.toggle('active'); // Animation de la croix
            navLinks.classList.toggle('hidden'); // Alterne l'affichage Tailwind
            navLinks.classList.toggle('flex');
        });

        // Ferme le menu quand on clique sur un lien (sur mobile)
        navLinks.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                burger.classList.remove('active');
                navLinks.classList.add('hidden');
                navLinks.classList.remove('flex');
            });
        });
    }


    // ==========================================
    // 3. APPARITION AU SCROLL (REVEAL)
    // ==========================================
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.remove('opacity-0', 'translate-y-7');
                entry.target.classList.add('opacity-100', 'translate-y-0');
                // Optionnel : observer.unobserve(entry.target); si on veut que ça n'arrive qu'une fois
            }
        });
    }, { threshold: 0.15 });

    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));


    // ==========================================
    // 4. MODULE OFFRES DE STAGES (Inspiré du TP 5)
    // ==========================================
    const offresGrid = document.getElementById('offres-grid');
    const searchInput = document.getElementById('search-input');
    
    // Fausse base de données (Mock)
    const mockOffres = [
        {
            id: 1,
            title: "Développeur Front-End React",
            company: "Agence WebTech — Paris (75)",
            promo: "MMI 2 / 3",
            desc: "Intégration d'interfaces web responsives et création de composants React pour nos clients grands comptes. Refonte complète du tunnel d'achat.",
            period: "01/04/2026 - 15/06/2026 (10 semaines)",
            remun: "Gratification légale",
            contact: "rh@webtech.fr",
            skills: ["HTML/CSS", "JavaScript", "React JS", "Git"]
        },
        {
            id: 2,
            title: "Assistant Chef de Projet Digital",
            company: "Com&Co — Marne-la-Vallée (77)",
            promo: "MMI 1 / 2",
            desc: "Suivi de production, gestion des plannings et relation client sur des projets de création de sites e-commerce sous WordPress.",
            period: "01/04/2026 - 31/05/2026 (8 semaines)",
            remun: "Non rémunéré",
            contact: "recrutement@comco.fr",
            skills: ["Gestion de projet", "WordPress", "Aisance relationnelle"]
        },
        {
            id: 3,
            title: "UI/UX Designer Junior",
            company: "Studio Créa — Meaux (77)",
            promo: "MMI 2",
            desc: "Refonte de l'application mobile d'une startup locale. Création de wireframes, maquettes haute fidélité et prototypage interactif sur Figma.",
            period: "01/04/2026 - 31/05/2026 (8 semaines)",
            remun: "Gratification légale",
            contact: "hello@studiocrea.design",
            skills: ["Figma", "Maquettage", "Tests utilisateurs"]
        }
    ];

    if (offresGrid) {
        
        // Fonction d'affichage des cartes (Génération DOM dynamique)
        function renderOffres(offres) {
            offresGrid.innerHTML = ''; 
            
            if (offres.length === 0) {
                offresGrid.innerHTML = '<p class="text-slate-500 italic col-span-full">Aucune offre ne correspond à votre recherche.</p>';
                return;
            }

            offres.forEach(offre => {
                const card = document.createElement('div');
                card.className = 'opacity-0 translate-y-4 animate-[fadeInUp_0.5s_ease-out_forwards] bg-white p-8 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between cursor-pointer';
                
                card.innerHTML = `
                    <div>
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-2xl font-bold text-slate-800">${offre.title}</h3>
                            <span class="bg-purple-100 text-brandStart px-3 py-1 rounded-full text-xs font-bold whitespace-nowrap ml-3">${offre.promo}</span>
                        </div>
                        <p class="font-medium text-slate-600 mb-4">${offre.company}</p>
                        <p class="text-slate-600 text-sm mb-6 line-clamp-2">${offre.desc}</p>
                    </div>
                    <button class="w-full rounded-xl bg-slate-50 text-slate-700 font-bold py-3 hover:bg-brandStart hover:text-white transition-colors shadow-sm">
                        Consulter l'offre
                    </button>
                `;

                // Écouteur de clic pour ouvrir le modal (Comme le TP5)
                card.addEventListener('click', () => openModal(offre.id));
                offresGrid.appendChild(card);
            });
        }

        // Initialisation affichage offres
        renderOffres(mockOffres);

        // Barre de recherche en temps réel (Filtre tableau JS)
        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                const term = e.target.value.toLowerCase();
                const filtered = mockOffres.filter(o => 
                    o.title.toLowerCase().includes(term) || 
                    o.company.toLowerCase().includes(term) ||
                    o.skills.some(skill => skill.toLowerCase().includes(term))
                );
                renderOffres(filtered);
            });
        }
    }

    // --- Modal Logic (Offres) ---
    const modal = document.getElementById('modal');
    const modalClose = document.getElementById('modal-close');
    const modalPostuler = document.getElementById('modal-postuler');

    // Fonction asynchrone pour simuler l'API Fetch
    async function openModal(id) {
        if(!modal) return;

        // Reset et affichage du loader
        document.getElementById('modal-title').textContent = 'Chargement...';
        document.getElementById('modal-company').textContent = '';
        document.getElementById('modal-loader').classList.remove('hidden');
        document.getElementById('modal-content').classList.add('hidden');
        if(modalPostuler) modalPostuler.disabled = true;
        
        modal.classList.remove('hidden');

        // Simulation d'un délai réseau (fetch)
        await new Promise(resolve => setTimeout(resolve, 600));

        const offre = mockOffres.find(o => o.id === id);

        if (offre) {
            document.getElementById('modal-title').textContent = offre.title;
            document.getElementById('modal-company').textContent = offre.company;
            document.getElementById('modal-desc').textContent = offre.desc;
            document.getElementById('modal-period').textContent = offre.period;
            document.getElementById('modal-remun').textContent = offre.remun;
            document.getElementById('modal-contact').textContent = offre.contact;
            
            document.getElementById('modal-tags').innerHTML = `<span class="bg-purple-100 text-brandStart px-3 py-1 rounded-full text-xs font-bold">${offre.promo}</span>`;

            const skillsContainer = document.getElementById('modal-skills');
            skillsContainer.innerHTML = '';
            offre.skills.forEach(skill => {
                const span = document.createElement('span');
                span.className = 'bg-slate-100 text-slate-600 px-3 py-1.5 rounded-lg text-xs font-medium border border-slate-200';
                span.textContent = skill;
                skillsContainer.appendChild(span);
            });

            document.getElementById('modal-loader').classList.add('hidden');
            document.getElementById('modal-content').classList.remove('hidden');
            if(modalPostuler) modalPostuler.disabled = false;
        }
    }

    function closeModal() {
        if(modal) modal.classList.add('hidden');
    }

    if (modalClose) modalClose.addEventListener('click', closeModal);
    if (modal) {
        modal.addEventListener('click', (e) => {
            if (e.target === modal) closeModal();
        });
    }


    // ==========================================
    // 5. MODULE SUIVI DES RECHERCHES (Inspiré du TP 3)
    // ==========================================
    const candidaturesGrid = document.getElementById('candidatures-grid');
    const statsRecherches = document.getElementById('stats-recherches');
    const selectTriRecherches = document.getElementById('tri-recherches');
    const btnAjouterRecherche = document.getElementById('btn-ajouter-recherche');
    const inputEntreprise = document.getElementById('input-entreprise');
    const inputPoste = document.getElementById('input-poste');
    const inputStatut = document.getElementById('input-statut');

    // Base de données simulée modifiable (let au lieu de const)
    let candidatures = [
        { id: 1, entreprise: 'Ubisoft', poste: 'Motion Designer', statut: 'attente', dateTimestamp: 1710240000000 },
        { id: 2, entreprise: 'Orange Business', poste: 'Intégrateur Web', statut: 'entretien', dateTimestamp: 1709894400000 },
        { id: 3, entreprise: 'Startup XYZ', poste: 'Community Manager', statut: 'refus', dateTimestamp: 1709289600000 }
    ];

    if (candidaturesGrid) {
        
        // Fonction d'affichage des candidatures
        function afficherCandidatures(liste) {
            candidaturesGrid.innerHTML = ''; 
            
            if (liste.length === 0) {
                candidaturesGrid.innerHTML = '<p class="text-slate-500 italic">Aucune candidature pour le moment.</p>';
                return;
            }

            liste.forEach(c => {
                let badgeClass = '';
                let badgeTexte = '';
                let iconBg = '';

                if (c.statut === 'entretien') {
                    badgeClass = 'bg-green-50 border-green-200 text-green-700';
                    badgeTexte = 'Entretien prévu';
                    iconBg = 'bg-green-100 text-green-700';
                } else if (c.statut === 'refus') {
                    badgeClass = 'bg-red-50 border-red-200 text-red-700';
                    badgeTexte = 'Refusé';
                    iconBg = 'bg-red-100 text-red-700';
                } else {
                    badgeClass = 'bg-orange-50 border-orange-200 text-orange-700';
                    badgeTexte = 'En attente';
                    iconBg = 'bg-orange-100 text-orange-700';
                }

                const initiale = c.entreprise.charAt(0).toUpperCase();

                candidaturesGrid.innerHTML += `
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 flex justify-between items-center hover:shadow-md transition-shadow animate-[fadeInUp_0.3s_ease-out_forwards]">
                        <div class="flex items-center gap-4">
                            <div class="${iconBg} w-12 h-12 rounded-xl flex items-center justify-center font-bold text-xl">
                                ${initiale}
                            </div>
                            <div>
                                <p class="font-bold text-slate-800">${c.entreprise}</p>
                                <p class="text-slate-500 text-sm">${c.poste}</p>
                            </div>
                        </div>
                        <div class="flex flex-col items-end gap-2">
                            <span class="${badgeClass} border text-xs font-bold px-3 py-1.5 rounded-lg whitespace-nowrap">
                                ${badgeTexte}
                            </span>
                            <button onclick="supprimerCandidature(${c.id})" class="text-xs text-slate-400 hover:text-red-500 transition-colors underline">
                                Supprimer
                            </button>
                        </div>
                    </div>
                `;
            });
        }

        // Fonction pour calculer et afficher les stats (reduce/filter du TP3)
        function afficherStatsRecherches() {
            if (candidatures.length === 0) {
                if(statsRecherches) statsRecherches.innerHTML = '';
                return;
            }

            const total = candidatures.length;
            const entretiens = candidatures.filter(c => c.statut === 'entretien').length;
            const refus = candidatures.filter(c => c.statut === 'refus').length;
            
            const taux = total > 0 ? ((entretiens / total) * 100).toFixed(0) : 0;

            if(statsRecherches) {
                statsRecherches.innerHTML = `
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 text-center">
                        <p class="text-slate-500 text-sm font-semibold uppercase tracking-wider mb-1">Total envoyées</p>
                        <p class="text-3xl font-bold text-slate-800">${total}</p>
                    </div>
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 text-center">
                        <p class="text-slate-500 text-sm font-semibold uppercase tracking-wider mb-1">Entretiens</p>
                        <p class="text-3xl font-bold text-brandStart">${entretiens}</p>
                    </div>
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 text-center">
                        <p class="text-slate-500 text-sm font-semibold uppercase tracking-wider mb-1">Taux d'entretien</p>
                        <p class="text-3xl font-bold text-green-500">${taux}%</p>
                    </div>
                `;
            }
        }

        // Fonction de tri (sort du TP3)
        function appliquerTriRecherches() {
            if(!selectTriRecherches) return;
            
            const tri = selectTriRecherches.value;
            let copie = [...candidatures]; 
            
            if (tri === 'recent') {
                copie.sort((a, b) => b.dateTimestamp - a.dateTimestamp);
            } else if (tri === 'alpha') {
                copie.sort((a, b) => a.entreprise.localeCompare(b.entreprise));
            } else if (tri === 'statut') {
                const ordre = { 'entretien': 1, 'attente': 2, 'refus': 3 };
                copie.sort((a, b) => ordre[a.statut] - ordre[b.statut]);
            }

            afficherCandidatures(copie);
        }

        // Ajout d'une recherche
        if (btnAjouterRecherche) {
            btnAjouterRecherche.addEventListener('click', () => {
                const entreprise = inputEntreprise.value.trim();
                const poste = inputPoste.value.trim();
                const statut = inputStatut.value;

                if (!entreprise || !poste) {
                    alert('Veuillez remplir le nom de l\'entreprise et le poste.');
                    return;
                }

                candidatures.push({
                    id: Date.now(),
                    entreprise: entreprise,
                    poste: poste,
                    statut: statut,
                    dateTimestamp: Date.now()
                });

                inputEntreprise.value = '';
                inputPoste.value = '';
                inputEntreprise.focus();

                afficherStatsRecherches();
                appliquerTriRecherches();
            });
        }

        // Fonction globale (window) pour pouvoir être appelée depuis un onclick HTML
        window.supprimerCandidature = function(id) {
            candidatures = candidatures.filter(c => c.id !== id);
            afficherStatsRecherches();
            appliquerTriRecherches();
        };

        if (selectTriRecherches) selectTriRecherches.addEventListener('change', appliquerTriRecherches);

        // Appel initial
        afficherStatsRecherches();
        appliquerTriRecherches();
    }
});