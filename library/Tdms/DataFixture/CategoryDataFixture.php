<?php
namespace Tdms\DataFixture;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Tdms\Entity\Category;

/**
 * Loads categories.
 */
class CategoryDataFixture implements FixtureInterface
{
	/**
	 * Loads basic product categories.
	 * 
	 * @param ObjectManager $manager
	 */
	public function load(ObjectManager $manager)
	{
		$categories = array('Food', 'Drink', 'Household', 'Goods');
		
		foreach ($categories as $name) {
			$category = new Category();
			
			$category->setName($name);
			
			$manager->persist($category);		
		}
		
		$manager->flush();
	}

	/**
	 * Gets fixture order.
	 */
	public function getOrder()
	{
		return 1;
	}
}