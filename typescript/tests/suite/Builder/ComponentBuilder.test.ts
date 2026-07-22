import { expect, test } from '@jest/globals';

import { AddQuotes } from '../../../src/Action/AddQuotes';
import { ConvertSpaceToUnderscore } from '../../../src/Action/ConvertSpaceToUnderscore';
import { ConvertToUpperCase } from '../../../src/Action/ConvertToUpperCase';
import { DefaultAction } from '../../../src/Action/DefaultAction';
import { ComponentBuilder } from '../../../src/Builder/ComponentBuilder';
import { Item } from '../../../src/Item/Item';
import { FormattedListVisitor } from '../../../src/Visitor/FormattedListVisitor';
import { TextVisitor } from '../../../src/Visitor/TextVisitor';

function createBuilder(): { builder: ComponentBuilder; lastId: number } {
  const builder = new ComponentBuilder();
  const rootId = builder.addSection('Shop', -1);

  let sectionId = builder.addSection('Electronics', rootId);
  let subSectionId = builder.addSection('Mobile Phones', sectionId);
  builder.addItem('Android Phones', subSectionId);
  builder.addItem('iPhones', subSectionId);
  builder.addItem('Budget Phones', subSectionId);

  subSectionId = builder.addSection('Laptops & Computers', sectionId);
  builder.addItem('Laptops', subSectionId);
  builder.addItem('Desktops', subSectionId);
  builder.addItem('Accessories', subSectionId);

  sectionId = builder.addSection('Home & Kitchen', rootId);
  subSectionId = builder.addSection('Kitchen Appliances', sectionId);
  builder.addItem('Air Fryers', subSectionId);
  builder.addItem('Mixers & Blenders', subSectionId);
  builder.addItem('Toasters', subSectionId);

  subSectionId = builder.addSection('Cookware', sectionId);
  builder.addItem('Non-stick Pans', subSectionId);
  builder.addItem('Stainless Steel Pots', subSectionId);
  const lastId = builder.addItem('Baking Trays', subSectionId);

  return { builder, lastId };
}

test('last id', () => {
  const { lastId } = createBuilder();

  expect(lastId).toBe(18);
});

test('formatted list catalog', () => {
  const { builder } = createBuilder();
  const root = builder.getProduct();

  root.iterate(new ConvertToUpperCase(), new AddQuotes());

  const visitor = new FormattedListVisitor();
  root.accept(visitor);

  expect(visitor.getResult().join('\n')).toBe(`SHOP
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
      'Baking Trays'`);
});

test('text catalog', () => {
  const { builder } = createBuilder();
  const root = builder.getProduct();

  root.iterate(new ConvertSpaceToUnderscore(), new ConvertSpaceToUnderscore());

  const visitor = new TextVisitor();
  root.accept(visitor);

  expect(visitor.getResult()).toBe(`> Shop | 
   > Electronics | 
     > Mobile_Phones | Android_Phones iPhones Budget_Phones 
     > Laptops_&_Computers | Laptops Desktops Accessories 
   > Home_&_Kitchen | 
     > Kitchen_Appliances | Air_Fryers Mixers_&_Blenders Toasters 
     > Cookware | Non-stick_Pans Stainless_Steel_Pots Baking_Trays`);
});

test('iterate with null actions preserves catalog', () => {
  const { builder } = createBuilder();
  const root = builder.getProduct();

  root.iterate();

  const visitor = new FormattedListVisitor();
  root.accept(visitor);

  expect(visitor.getResult()).toEqual([
    'Shop',
    '  Electronics',
    '    Mobile Phones',
    '      Android Phones',
    '      iPhones',
    '      Budget Phones',
    '    Laptops & Computers',
    '      Laptops',
    '      Desktops',
    '      Accessories',
    '  Home & Kitchen',
    '    Kitchen Appliances',
    '      Air Fryers',
    '      Mixers & Blenders',
    '      Toasters',
    '    Cookware',
    '      Non-stick Pans',
    '      Stainless Steel Pots',
    '      Baking Trays',
  ]);
});

test('only one root', () => {
  const builder = new ComponentBuilder();

  builder.addSection('Root', -1);

  expect(() => builder.addSection('Root', -1)).toThrow('Duplicated root');
});

test('item cannot hold other items', () => {
  const builder = new ComponentBuilder();
  const rootId = builder.addSection('Root', -1);
  const itemId = builder.addItem('Item 1', rootId);

  expect(() => builder.addItem('Item 2', itemId)).toThrow('Cannot add Item to another Item');
});

test('parent must exist', () => {
  const builder = new ComponentBuilder();
  builder.addSection('Root', -1);

  expect(() => builder.addItem('Item 1', 123)).toThrow('Invalid parentId');
});

test('parent must exist before items can be added', () => {
  const builder = new ComponentBuilder();

  expect(() => builder.addItem('Item 1', 0)).toThrow('Invalid parentId');
});

test('default action does not change item title', () => {
  const item = new Item('Item 1');

  new DefaultAction().apply(item);

  expect(item.getTitle()).toBe('Item 1');
});
