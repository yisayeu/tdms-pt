<?php
namespace Tdms\DataFixture;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Tdms\Entity\Product;

/**
 * Loads categories.
 */
class ProductDataFixture implements FixtureInterface
{
	/**
	 * Loads basic product categories.
	 * 
	 * @param ObjectManager $manager
	 */
	public function load(ObjectManager $manager)
	{		
		$categories = $manager->getRepository('Tdms\Entity\Category')->findAll();

		for ($i = 0; $i < 30; $i++) {
			$product = new Product();
			
			$product->setName(ucfirst(substr(md5(microtime()), 0, 8)));
			$product->setCategory($categories[rand(0, count($categories) - 1)]);
			
			$manager->persist($product);
		}
		
		$manager->flush();
	}

	/**
	 * Gets fixture order.
	 */
	public function getOrder()
	{
		return 2;
	}
}