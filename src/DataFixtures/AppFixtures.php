<?php

namespace App\DataFixtures;

use App\Entity\MgCategories;
use App\Entity\MgCategoryLang;
use App\Entity\MgDepartmentsFrench;
use App\Entity\MgGenders;
use App\Entity\MgOrdersStatusLang;
use App\Entity\MgParameterBasket;
use App\Entity\MgParameters;
use App\Entity\MgRegionsFrench;
use App\Entity\MgTaxes;
use App\Entity\MgTaxesLang;
use App\Entity\MgUsers;
use App\Repository\MgCategoriesRepository;
use App\Repository\MgGendersRepository;
use App\Repository\MgLanguagesRepository;
use App\Repository\MgRegionsFrenchRepository;
use App\Repository\MgTaxesRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
	private $encoder;
	private $gender;
	private $language;
    private $taxe;
    private $categories;
    private $regionsFrench;

	public function __construct(UserPasswordEncoderInterface $encoder, MgGendersRepository $gender, MgLanguagesRepository $language, MgTaxesRepository $taxe, MgCategoriesRepository $categories, MgRegionsFrenchRepository $regionsFrench)
	{
		$this->encoder = $encoder;
		$this->gender = $gender;
		$this->language = $language;
        $this->taxe = $taxe;
        $this->categories = $categories;
        $this->regionsFrench = $regionsFrench;
	}

    public function load(ObjectManager $manager)
    {
        // Les paramètres
        $params = new MgParameters;
        $params->setTitle('Votre boutique')
            ->setSlogan('Ma super boutique')
            ->setEmailContact('contact@email.com')
            ->setNbPosts(6);
            $manager->persist($params);
        $params = new MgParameters;
        // Les paramètres de boutique
        $param_basket = new MgParameterBasket;
        $param_basket->setQtyMinCart(1)
            ->setAmountMinCart(1)
            ->setMajorityRequired(0);
            $manager->persist($param_basket);
        //Les genres/civilités
        $gender = new MgGenders;
        $gender->setShortGender('M.')
        	->setNameGender('Monsieur');
        $manager->persist($gender);
        $gender = new MgGenders;
        $gender->setShortGender('Mme.')
        	->setNameGender('Madame');
        $manager->persist($gender);
        $manager->flush();

    	//Insertion d'un utilisateur
    	$user = new MgUsers();
    	$password = $this->encoder->encodePassword($user, 'Abcd1234');
    	$user->setGender($this->gender->find(1))
    		->setUsername('gauvain49')
    		->setRoles(array('ROLE_SUPER_ADMIN'))
    		->setPassword($password)
    		->setLastname('Moreau')
    		->setFirstname('Grégory')
    		->setEmail('contact@percevalcreation.fr')
    		->setDateCreat(new \DateTime())
    		->setActive(true);
        $manager->persist($user);
        $manager->flush();

        //Insertion des taxes
        $taxes = new MgTaxes();
        $taxes->setTaxeName('Aucune Taxe')
                ->setTaxeRate(0.00)
            ->setTaxeActive(true);
        $manager->persist($taxes);
        $taxes = new MgTaxes();
        $taxes->setTaxeName('TVA FR 10%')
            ->setTaxeRate(10.00)
            ->setTaxeActive(true);
        $manager->persist($taxes);
        $taxes = new MgTaxes();
        $taxes->setTaxeName('TVA FR 20%')
            ->setTaxeRate(20.00)
            ->setTaxeActive(true);
        $manager->persist($taxes);
        $taxes = new MgTaxes();
        $taxes->setTaxeName('TVA FR 5,5%')
            ->setTaxeRate(5.50)
            ->setTaxeActive(true);
        $manager->persist($taxes);
        $manager->flush();

        //Insertion des catégories
        $category = new MgCategories();
        $category->setName('racine')
            ->setSlug('root')
            ->setActive(true)
            ->setForceDisplay(true)
            ->setType('root')
            ->setLevel(0)
            ->setPosition(1);
        $manager->persist($category);
        $manager->flush();

        //Insertion des statuts de paiement des commandes
        /*$orderStatutPayment = new MgOrdersStatusLang();
        $orderStatutPayment->setLang($this->language->find(1))
            ->setName('En attente du paiement par chèque');
        $manager->persist($orderStatutPayment);
        $orderStatutPayment = new MgOrdersStatusLang();
        $orderStatutPayment->setLang($this->language->find(1))
            ->setName('Paiement accepté');
        $manager->persist($orderStatutPayment);
        $orderStatutPayment = new MgOrdersStatusLang();
        $orderStatutPayment->setLang($this->language->find(1))
            ->setName('En cours de préparation');
        $manager->persist($orderStatutPayment);
        $orderStatutPayment = new MgOrdersStatusLang();
        $orderStatutPayment->setLang($this->language->find(1))
            ->setName('Expédié');
        $manager->persist($orderStatutPayment);
        $orderStatutPayment = new MgOrdersStatusLang();
        $orderStatutPayment->setLang($this->language->find(1))
            ->setName('Livré');
        $manager->persist($orderStatutPayment);
        $orderStatutPayment = new MgOrdersStatusLang();
        $orderStatutPayment->setLang($this->language->find(1))
            ->setName('Annulé');
        $manager->persist($orderStatutPayment);
        $orderStatutPayment = new MgOrdersStatusLang();
        $orderStatutPayment->setLang($this->language->find(1))
            ->setName('Remboursé');
        $manager->persist($orderStatutPayment);
        $orderStatutPayment = new MgOrdersStatusLang();
        $orderStatutPayment->setLang($this->language->find(1))
            ->setName('Erreur de paiement');
        $manager->persist($orderStatutPayment);
        $orderStatutPayment = new MgOrdersStatusLang();
        $orderStatutPayment->setLang($this->language->find(1))
            ->setName('En attente de réapprovisionnement (payé)');
        $manager->persist($orderStatutPayment);
        $orderStatutPayment = new MgOrdersStatusLang();
        $orderStatutPayment->setLang($this->language->find(1))
            ->setName('En attente de virement bancaire');
        $manager->persist($orderStatutPayment);
        $orderStatutPayment = new MgOrdersStatusLang();
        $orderStatutPayment->setLang($this->language->find(1))
            ->setName('Paiement à distance accepté');
        $manager->persist($orderStatutPayment);
        $orderStatutPayment = new MgOrdersStatusLang();
        $orderStatutPayment->setLang($this->language->find(1))
            ->setName('En attente de réapprovisionnement (non payé)');
        $manager->persist($orderStatutPayment);
        $orderStatutPayment = new MgOrdersStatusLang();
        $orderStatutPayment->setLang($this->language->find(1))
            ->setName('En attente de paiement à la livraison');
        $manager->persist($orderStatutPayment);
        $orderStatutPayment = new MgOrdersStatusLang();
        $orderStatutPayment->setLang($this->language->find(1))
            ->setName('En attente de paiement');
        $manager->persist($orderStatutPayment);
        $manager->flush();*/

        //Insertion des régions françaises
        $regions = new MgRegionsFrench();
        $regions->setCodeIso('FR-ARA')
            ->setName('Auvergne-Rhône-Alpes');
        $manager->persist($regions);
        $regions = new MgRegionsFrench();
        $regions->setCodeIso('FR-BFC')
            ->setName('Bourgogne-Franche-Comté');
        $manager->persist($regions);
        $regions = new MgRegionsFrench();
        $regions->setCodeIso('FR-BRE')
            ->setName('Bretagne');
        $manager->persist($regions);
        $regions = new MgRegionsFrench();
        $regions->setCodeIso('FR-CVL')
            ->setName('Centre-Val de Loire');
        $manager->persist($regions);
        $regions = new MgRegionsFrench();
        $regions->setCodeIso('FR-COR')
            ->setName('Corse');
        $manager->persist($regions);
        $regions = new MgRegionsFrench();
        $regions->setCodeIso('FR-GES')
            ->setName('Grand Est');
        $manager->persist($regions);
        $regions = new MgRegionsFrench();
        $regions->setCodeIso('FR-HDF')
            ->setName('Hauts-de-France');
        $manager->persist($regions);
        $regions = new MgRegionsFrench();
        $regions->setCodeIso('FR-IDF')
            ->setName('Île-de-France');
        $manager->persist($regions);
        $regions = new MgRegionsFrench();
        $regions->setCodeIso('FR-NOR')
            ->setName('Normandie');
        $manager->persist($regions);
        $regions = new MgRegionsFrench();
        $regions->setCodeIso('FR-NAQ')
            ->setName('Nouvelle-Aquitaine');
        $manager->persist($regions);
        $regions = new MgRegionsFrench();
        $regions->setCodeIso('FR-OCC')
            ->setName('Occitanie');
        $manager->persist($regions);
        $regions = new MgRegionsFrench();
        $regions->setCodeIso('FR-PDL')
            ->setName('Pays de la Loire');
        $manager->persist($regions);
        $regions = new MgRegionsFrench();
        $regions->setCodeIso('FR-PAC')
            ->setName("Provence-Alpes-Côte d'Azur");
        $manager->persist($regions);
        $regions = new MgRegionsFrench();
        $regions->setCodeIso('FR-GUA')
            ->setName('Guadeloupe');
        $manager->persist($regions);
        $regions = new MgRegionsFrench();
        $regions->setCodeIso('FR-MTQ')
            ->setName('Martinique');
        $manager->persist($regions);
        $regions = new MgRegionsFrench();
        $regions->setCodeIso('FR-GUF')
            ->setName('Guyane');
        $manager->persist($regions);
        $regions = new MgRegionsFrench();
        $regions->setCodeIso('FR-LRE')
            ->setName('La Réunion');
        $manager->persist($regions);
        $regions = new MgRegionsFrench();
        $regions->setCodeIso('FR-MAY')
            ->setName('Mayotte');
        $manager->persist($regions);
        $manager->flush();

        //Insertion des départements français
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('01')
            ->setName('Ain')
            ->setRegion($this->regionsFrench->find(1));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('02')
            ->setName('Aisne')
            ->setRegion($this->regionsFrench->find(7));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('03')
            ->setName('Allier')
            ->setRegion($this->regionsFrench->find(1));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('04')
            ->setName('Alpes-de-Haute-Provence')
            ->setRegion($this->regionsFrench->find(13));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('05')
            ->setName('Hautes-Alpes')
            ->setRegion($this->regionsFrench->find(13));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('06')
            ->setName('Alpes-Maritimes')
            ->setRegion($this->regionsFrench->find(13));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('07')
            ->setName('Ardèche')
            ->setRegion($this->regionsFrench->find(13));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('08')
            ->setName('Ardennes')
            ->setRegion($this->regionsFrench->find(6));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('09')
            ->setName('Ariège')
            ->setRegion($this->regionsFrench->find(11));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('10')
            ->setName('Aube')
            ->setRegion($this->regionsFrench->find(6));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('11')
            ->setName('Aude')
            ->setRegion($this->regionsFrench->find(11));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('12')
            ->setName('Aveyron')
            ->setRegion($this->regionsFrench->find(11));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('13')
            ->setName('Bouches-du-Rhône')
            ->setRegion($this->regionsFrench->find(13));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('14')
            ->setName('Calvados')
            ->setRegion($this->regionsFrench->find(9));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('15')
            ->setName('Cantal')
            ->setRegion($this->regionsFrench->find(1));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('16')
            ->setName('Charente')
            ->setRegion($this->regionsFrench->find(10));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('17')
            ->setName('Charente-Maritime')
            ->setRegion($this->regionsFrench->find(10));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('18')
            ->setName('Cher')
            ->setRegion($this->regionsFrench->find(4));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('19')
            ->setName('Corrèze')
            ->setRegion($this->regionsFrench->find(10));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('20')
            ->setName('Corse')
            ->setRegion($this->regionsFrench->find(5));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('2A')
            ->setName('Corse-du-Sud')
            ->setRegion($this->regionsFrench->find(5));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('2B')
            ->setName('Haute-Corse')
            ->setRegion($this->regionsFrench->find(5));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('21')
            ->setName('Côte-d\'or')
            ->setRegion($this->regionsFrench->find(2));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('22')
            ->setName('Côtes-d\'Armor')
            ->setRegion($this->regionsFrench->find(3));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('23')
            ->setName('Creuse')
            ->setRegion($this->regionsFrench->find(10));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('24')
            ->setName('Dordogne')
            ->setRegion($this->regionsFrench->find(10));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('25')
            ->setName('Doubs')
            ->setRegion($this->regionsFrench->find(2));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('26')
            ->setName('Drôme')
            ->setRegion($this->regionsFrench->find(1));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('27')
            ->setName('Eure')
            ->setRegion($this->regionsFrench->find(9));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('28')
            ->setName('Eure-et-Loire')
            ->setRegion($this->regionsFrench->find(4));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('29')
            ->setName('Finistère')
            ->setRegion($this->regionsFrench->find(3));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('30')
            ->setName('Gard')
            ->setRegion($this->regionsFrench->find(11));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('31')
            ->setName('Haute-Garonne')
            ->setRegion($this->regionsFrench->find(11));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('32')
            ->setName('Gers')
            ->setRegion($this->regionsFrench->find(11));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('33')
            ->setName('Gironde')
            ->setRegion($this->regionsFrench->find(10));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('34')
            ->setName('Hérault')
            ->setRegion($this->regionsFrench->find(11));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('35')
            ->setName('Ille-et-Vilaine')
            ->setRegion($this->regionsFrench->find(3));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('36')
            ->setName('Indre')
            ->setRegion($this->regionsFrench->find(4));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('37')
            ->setName('Indre-et-Loire')
            ->setRegion($this->regionsFrench->find(4));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('38')
            ->setName('Isère')
            ->setRegion($this->regionsFrench->find(1));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('39')
            ->setName('Jura')
            ->setRegion($this->regionsFrench->find(2));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('40')
            ->setName('Landes')
            ->setRegion($this->regionsFrench->find(10));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('41')
            ->setName('Loir-et-Cher')
            ->setRegion($this->regionsFrench->find(4));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('42')
            ->setName('Loire')
            ->setRegion($this->regionsFrench->find(1));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('43')
            ->setName('Haute-Loire')
            ->setRegion($this->regionsFrench->find(1));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('44')
            ->setName('Loire-Atlantique')
            ->setRegion($this->regionsFrench->find(12));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('45')
            ->setName('Loiret')
            ->setRegion($this->regionsFrench->find(4));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('46')
            ->setName('Lot')
            ->setRegion($this->regionsFrench->find(11));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('47')
            ->setName('Lot-et-Garonne')
            ->setRegion($this->regionsFrench->find(10));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('48')
            ->setName('Lozère')
            ->setRegion($this->regionsFrench->find(11));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('49')
            ->setName('Maine-et-Loire')
            ->setRegion($this->regionsFrench->find(12));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('50')
            ->setName('Manche')
            ->setRegion($this->regionsFrench->find(9));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('51')
            ->setName('Marne')
            ->setRegion($this->regionsFrench->find(6));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('52')
            ->setName('Haute-Marne')
            ->setRegion($this->regionsFrench->find(6));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('53')
            ->setName('Mayenne')
            ->setRegion($this->regionsFrench->find(12));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('54')
            ->setName('Meurthe-et-Moselle')
            ->setRegion($this->regionsFrench->find(6));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('55')
            ->setName('Meuse')
            ->setRegion($this->regionsFrench->find(6));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('56')
            ->setName('Morbihan')
            ->setRegion($this->regionsFrench->find(3));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('57')
            ->setName('Moselle')
            ->setRegion($this->regionsFrench->find(6));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('58')
            ->setName('Nièvre')
            ->setRegion($this->regionsFrench->find(2));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('59')
            ->setName('Nord')
            ->setRegion($this->regionsFrench->find(7));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('60')
            ->setName('Oise')
            ->setRegion($this->regionsFrench->find(7));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('61')
            ->setName('Orne')
            ->setRegion($this->regionsFrench->find(9));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('62')
            ->setName('Pas-de-Calais')
            ->setRegion($this->regionsFrench->find(7));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('63')
            ->setName('Puy-de-Dôme')
            ->setRegion($this->regionsFrench->find(1));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('64')
            ->setName('Pyrénées-Atlantique')
            ->setRegion($this->regionsFrench->find(10));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('65')
            ->setName('Hautes-Pyrénées')
            ->setRegion($this->regionsFrench->find(11));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('66')
            ->setName('Pyrénées-Orientales')
            ->setRegion($this->regionsFrench->find(11));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('67')
            ->setName('Bas-Rhin')
            ->setRegion($this->regionsFrench->find(6));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('68')
            ->setName('Haut-Rhin')
            ->setRegion($this->regionsFrench->find(6));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('69')
            ->setName('Rhône')
            ->setRegion($this->regionsFrench->find(1));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('70')
            ->setName('Haute-Saône')
            ->setRegion($this->regionsFrench->find(2));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('71')
            ->setName('Saône-et-Loire')
            ->setRegion($this->regionsFrench->find(2));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('72')
            ->setName('Sarthe')
            ->setRegion($this->regionsFrench->find(12));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('73')
            ->setName('Savoie')
            ->setRegion($this->regionsFrench->find(1));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('74')
            ->setName('Haute-Savoie')
            ->setRegion($this->regionsFrench->find(1));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('75')
            ->setName('Paris')
            ->setRegion($this->regionsFrench->find(8));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('76')
            ->setName('Seine-Maritime')
            ->setRegion($this->regionsFrench->find(9));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('77')
            ->setName('Seine-et-Marne')
            ->setRegion($this->regionsFrench->find(8));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('78')
            ->setName('Yvelines')
            ->setRegion($this->regionsFrench->find(8));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('79')
            ->setName('Deux-Sèvres')
            ->setRegion($this->regionsFrench->find(10));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('80')
            ->setName('Somme')
            ->setRegion($this->regionsFrench->find(7));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('81')
            ->setName('Tarn')
            ->setRegion($this->regionsFrench->find(11));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('82')
            ->setName('Tarn-et-Garonne')
            ->setRegion($this->regionsFrench->find(11));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('83')
            ->setName('Var')
            ->setRegion($this->regionsFrench->find(13));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('84')
            ->setName('Vaucluse')
            ->setRegion($this->regionsFrench->find(13));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('85')
            ->setName('Vendée')
            ->setRegion($this->regionsFrench->find(12));
        $department->setCodeInsee('86')
            ->setName('Vienne')
            ->setRegion($this->regionsFrench->find(10));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('87')
            ->setName('Haute-Vienne')
            ->setRegion($this->regionsFrench->find(10));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('88')
            ->setName('Vosges')
            ->setRegion($this->regionsFrench->find(6));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('89')
            ->setName('Yonne')
            ->setRegion($this->regionsFrench->find(2));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('90')
            ->setName('Territoire de Belfort')
            ->setRegion($this->regionsFrench->find(2));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('91')
            ->setName('Essonne')
            ->setRegion($this->regionsFrench->find(8));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('92')
            ->setName('Hauts-de-Seine')
            ->setRegion($this->regionsFrench->find(8));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('93')
            ->setName('Seine-Saint-Denis')
            ->setRegion($this->regionsFrench->find(8));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('94')
            ->setName('Val-de-Marne')
            ->setRegion($this->regionsFrench->find(8));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('95')
            ->setName('Val-d\'Oise')
            ->setRegion($this->regionsFrench->find(8));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('971')
            ->setName('Guadeloupe')
            ->setRegion($this->regionsFrench->find(14));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('972')
            ->setName('Martinique')
            ->setRegion($this->regionsFrench->find(15));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('973')
            ->setName('Guyane')
            ->setRegion($this->regionsFrench->find(16));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('974')
            ->setName('La Réunion')
            ->setRegion($this->regionsFrench->find(17));
        $manager->persist($department);
        $department = new MgDepartmentsFrench();
        $department->setCodeInsee('976')
            ->setName('Mayotte')
            ->setRegion($this->regionsFrench->find(1));
        $manager->persist($department);
        $manager->flush();
    }
}
