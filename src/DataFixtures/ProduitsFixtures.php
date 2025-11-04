<?php

namespace App\DataFixtures;

use App\Entity\Produits;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProduitsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $produits = [
            [
                'nom' => 'Processeur AMD Ryzen 7 5800X',
                'description' => '8 cœurs, 16 threads, fréquence de base 3.8 GHz. Idéal pour le gaming et la création de contenu.',
                'stock' => 15,
                'prix' => 349.99,
                'image' => 'https://cdn.mos.cms.futurecdn.net/9nAmJrK7PcN4zqoe9svJwH.jpg',
            ],
            [
                'nom' => 'Carte Graphique NVIDIA RTX 4070 Ti',
                'description' => '12 Go de GDDR6X, architecture Ada Lovelace. Performances gaming exceptionnelles en 1440p et 4K.',
                'stock' => 8,
                'prix' => 899.99,
                'image' => 'https://www.nvidia.com/content/dam/en-zz/Solutions/geforce/ada/rtx-4070-ti/gallery/geforce-rtx-4070-ti-gallery-thumb-1-3840x2160.jpg',
            ],
            [
                'nom' => 'Carte Mère ASUS ROG STRIX B550-F GAMING',
                'description' => 'Socket AM4, compatible Ryzen, PCIe 4.0, design RGB. Excellente base pour un setup gaming.',
                'stock' => 20,
                'prix' => 189.99,
                'image' => 'https://dlcdnwebimgs.asus.com/gain/1B8F06ED-7E1D-4F7E-A6CB-9127C14A637B/w717/h525',
            ],
            [
                'nom' => 'Mémoire RAM Corsair Vengeance RGB Pro 16 Go (2x8 Go) DDR4 3600 MHz',
                'description' => 'Performance et design RGB pour les gamers exigeants.',
                'stock' => 25,
                'prix' => 89.99,
                'image' => 'https://m.media-amazon.com/images/I/61OBw+8HOoL._AC_SL1500_.jpg',
            ],
            [
                'nom' => 'SSD Samsung 980 PRO 1 To NVMe M.2',
                'description' => 'Vitesses de lecture jusqu’à 7000 Mo/s. Ultra rapide pour les gamers et créateurs.',
                'stock' => 30,
                'prix' => 129.99,
                'image' => 'https://images.samsung.com/is/image/samsung/p6pim/uk/mz-v8p1t0bamc-00/mz-v8p1t0bamc-00-gallery-01-360246674?$684_547_PNG$',
            ],
            [
                'nom' => 'Boîtier PC NZXT H510 Elite',
                'description' => 'Design moderne avec panneau en verre trempé et gestion des câbles optimisée.',
                'stock' => 12,
                'prix' => 159.99,
                'image' => 'https://m.media-amazon.com/images/I/71Q68kC5E0L._AC_SL1500_.jpg',
            ],
            [
                'nom' => 'Alimentation Corsair RM850x 850W 80+ Gold',
                'description' => 'Haute efficacité et silence, câbles modulaires, garantie 10 ans.',
                'stock' => 18,
                'prix' => 139.99,
                'image' => 'https://m.media-amazon.com/images/I/71xrRRaHxNL._AC_SL1500_.jpg',
            ],
            [
                'nom' => 'Refroidisseur CPU Noctua NH-U12S redux',
                'description' => 'Refroidissement silencieux et performant pour processeurs haut de gamme.',
                'stock' => 22,
                'prix' => 59.99,
                'image' => 'https://noctua.at/pub/media/catalog/product/cache/79d0c10f83cc0e5156f1e2e7c14e91e8/n/h/nh_u12s_redux_1_1.jpg',
            ],
            [
                'nom' => 'Clavier Mécanique Logitech G PRO X',
                'description' => 'Switchs interchangeables, rétroéclairage RGB, conçu pour les pros de l’eSport.',
                'stock' => 16,
                'prix' => 129.99,
                'image' => 'https://resource.logitechg.com/d_transparent.gif/content/dam/gaming/en/products/pro-x-keyboard/pro-x-keyboard-gallery-1.png',
            ],
            [
                'nom' => 'Souris Logitech G502 HERO',
                'description' => 'Capteur 25K DPI, poids ajustable, 11 boutons programmables.',
                'stock' => 28,
                'prix' => 69.99,
                'image' => 'https://resource.logitechg.com/d_transparent.gif/content/dam/gaming/en/products/g502-hero/g502-hero-gallery-1.png',
            ],
        ];

        foreach ($produits as $data) {
            $produit = new Produits();
            $produit->setNomProduit($data['nom']);
            $produit->setDescriptionProduit($data['description']);
            $produit->setStock($data['stock']);
            $produit->setPrixProduit($data['prix']);
            $produit->setImageProduit($data['image']);
            $manager->persist($produit);
        }

        $manager->flush();
    }
}
