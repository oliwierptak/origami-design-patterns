<?php declare(strict_types=1);

namespace TestDesignPatterns\Origami\Builder;

use DesignPatterns\Origami\Action\AddQuotes;
use DesignPatterns\Origami\Action\ConvertSpaceToUnderscore;
use DesignPatterns\Origami\Action\ConvertToUpperCase;
use DesignPatterns\Origami\Builder\BuilderInterface;
use DesignPatterns\Origami\Builder\ComponentBuilder;
use DesignPatterns\Origami\Visitor\FormattedListVisitor;
use DesignPatterns\Origami\Visitor\TextVisitor;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ComponentBuilderTest extends TestCase
{
    private BuilderInterface $builder;
    private int $lastId;

    public function test_lastId(): void
    {
        $this->assertEquals(18, $this->lastId);
    }

    public function test_formatted_list_catalog(): void
    {
        $root = $this->builder->getProduct();

        // convert section names to uppercase, and add quotes around item names
        $root->iterate(new ConvertToUpperCase(), new AddQuotes());

        $v = new FormattedListVisitor();
        $root->accept($v);
        $lines = $v->getResult();

        $s = implode("\n", $lines);

        $this->assertEquals("SHOP
  ELECTRONICS
    MOBILE PHONES
      'Android Phones'
      'iPhones'
      'Budget Phones'
    LAPTOPS & COMPUTERS
      'Laptops'
      'Desktops'
      'Accessories'
  HOME & KITCHEN
    KITCHEN APPLIANCES
      'Air Fryers'
      'Mixers & Blenders'
      'Toasters'
    COOKWARE
      'Non-stick Pans'
      'Stainless Steel Pots'
      'Baking Trays'", $s);
    }

    public function test_text_catalog(): void
    {
        $root = $this->builder->getProduct();

        // replace spaces with underscores in section and item names
        $root->iterate(new ConvertSpaceToUnderscore(), new ConvertSpaceToUnderscore());

        $v = new TextVisitor();
        $root->accept($v);
        $lines = $v->getResult();

        $this->assertEquals("> Shop | 
   > Electronics | 
     > Mobile_Phones | Android_Phones iPhones Budget_Phones 
     > Laptops_&_Computers | Laptops Desktops Accessories 
   > Home_&_Kitchen | 
     > Kitchen_Appliances | Air_Fryers Mixers_&_Blenders Toasters 
     > Cookware | Non-stick_Pans Stainless_Steel_Pots Baking_Trays", $lines);
    }

    public function test_only_one_root(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageIs('Duplicated root');

        $this->builder = new ComponentBuilder();

        $this->builder->addSection("Root", -1);
        $this->builder->addSection("Root", -1);
    }

    public function test_item_cannot_hold_other_items(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageIs('Cannot add Item to another Item');

        $this->builder = new ComponentBuilder();

        $rootId = $this->builder->addSection("Root", -1);
        $itemId = $this->builder->addItem("Item 1", $rootId);
        $this->builder->addItem("Item 2", $itemId);
    }

    public function test_parent_must_exist(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageIs('Invalid parentId');

        $this->builder = new ComponentBuilder();

        $this->builder->addSection("Root", -1);
        $this->builder->addItem("Item 1", 123);
    }

    public function test_parent_must_exist_before_items_can_be_added(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageIs('Invalid parentId');

        $this->builder = new ComponentBuilder();
        $this->builder->addItem("Item 1", 0);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->builder = new ComponentBuilder();
        $rootId = $this->builder->addSection("Shop", -1);

        $sectionId = $this->builder->addSection("Electronics", $rootId);
        $subSectionId = $this->builder->addSection("Mobile Phones", $sectionId);
        $this->builder->addItem("Android Phones", $subSectionId);
        $this->builder->addItem("iPhones", $subSectionId);
        $this->builder->addItem("Budget Phones", $subSectionId);

        $subSectionId = $this->builder->addSection("Laptops & Computers", $sectionId);
        $this->builder->addItem("Laptops", $subSectionId);
        $this->builder->addItem("Desktops", $subSectionId);
        $this->builder->addItem("Accessories", $subSectionId);

        $sectionId = $this->builder->addSection("Home & Kitchen", $rootId);
        $subSectionId = $this->builder->addSection("Kitchen Appliances", $sectionId);
        $this->builder->addItem("Air Fryers", $subSectionId);
        $this->builder->addItem("Mixers & Blenders", $subSectionId);
        $this->builder->addItem("Toasters", $subSectionId);

        $subSectionId = $this->builder->addSection("Cookware", $sectionId);
        $this->builder->addItem("Non-stick Pans", $subSectionId);
        $this->builder->addItem("Stainless Steel Pots", $subSectionId);
        $this->lastId = $this->builder->addItem("Baking Trays", $subSectionId);
    }
}
