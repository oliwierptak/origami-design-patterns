# Origami Design Patterns for Recursive Data Structures

"Origami" Design Patterns is a collection of architectural and design patterns that focus on reducing coupling between
modules by promoting Composition over Inheritance.

It uses the following Gang of Four (GoF) concepts:

- Composite
- Builder
- Iterator
- Visitor

Origami is less about inventing new design patterns and more about combining well-known object-oriented patterns into
 a unified architectural style centered on composition, explicit dependencies, and small, focused components.

### Composite

Enables access to simple and complex objects in a unified way.
Enables modeling tree (recursive) data structures.
The key factor is the supertype shared between both, atomic and aggregated objects.

### Builder

Allows building a Composite structure.
A client knows only about the parts that require assembling,
so it delegates the process to the Builder that knows all the details about creating and storing the Composite (product).

### Iterator

Allows access to elements without exposing underlying implementation details.
Enables linear access to elements of the Composite.

### Visitor

Allows separation of object behavior from its structure.
Enables shape-based access to elements of the Composite.

## Example Application: Product Catalog

An example OS Commerce application, which demonstrates how the Product Catalog can be assembled,
iterated over, and traversed using a
decoupled, isolated architecture.

The Product Catalog structure is made of `Items` and `Sections`.

```
Shop
  Electronics
    Mobile Phones
      Android Phones
      iPhones
      Budget Phones
    Laptops & Computers
      Laptops
      Desktops
      Accessories
  Home & Kitchen
    Kitchen Appliances
      Air Fryers
      Mixers & Blenders
      Toasters
    Cookware
      Non-stick Pans
      Stainless Steel Pots
      Baking Trays
```

### Composite (Item, Section)

The `Item` has a title, while the `Section` has a title and a collection of subcomponents.

### Builder (ComponentBuilder)

The Product Catalog is built only with `Section` and `Item` components.
The nested hierarchy is represented by `parentId` identifier, linking Sections and Items as children of existing
components.

### Iterator (ItemIterator, SectionIterator)

The composite can be iterated using an *internal* traversal that can modify any `Item` component.

### Visitor (FormattedListVisitor, TextVisitor)

The composite can also be traversed using a visitor, which should not modify any `Item` components.

## Usage Example

### Generate Product Catalog as formatted list

Formatted Product Catalog structure, where section names are uppercased, and item names are quoted.


```php
$builder = new ComponentBuilder();
// ... build the product catalog
$visitor = new FormattedListVisitor();
$product = $builder->getProduct();

$product->iterate(new ConvertToUpperCase, new AddQuotes);
$product->accept($visitor);

$output = $visitor->getResult();
```

```
SHOP
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
      'Baking Trays'
```

### Generate Product Catalog as text

Product Catalog as text, where spaces were replaced with underscores in section and item names.

```typescript
const builder = new ComponentBuilder();
// ... build the product catalog
const visitor = new TextVisitor();
const product = builder.getProduct();

product.iterate(new ConvertSpaceToUnderscore(), new ConvertSpaceToUnderscore());
product.accept(visitor);

const output = visitor.getResult();
```

```
> Shop | 
   > Electronics | 
     > Mobile_Phones | Android_Phones iPhones Budget_Phones 
     > Laptops_&_Computers | Laptops Desktops Accessories 
   > Home_&_Kitchen | 
     > Kitchen_Appliances | Air_Fryers Mixers_&_Blenders Toasters 
     > Cookware | Non-stick_Pans Stainless_Steel_Pots Baking_Trays
```

## Benefits of using "Origami" Design Patterns

- High reusability
- Low coupling
- Easy testing
- Flexible architecture
- Easier maintenance
- Better scalability
- Encourages clean architecture and domain-driven design practices

"Origami" Design Patterns promote building software from small, composable, loosely coupled components,
simplifying complex applications by making them easier to understand, test, maintain, and extend.

See code examples for [PHP](php) and [TypeScript](typescript).