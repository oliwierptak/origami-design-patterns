import { ComponentInterface } from '../ComponentInterface';
import { Item } from '../Item/Item';
import { Section } from '../Section/Section';
import { SectionInterface } from '../Section/SectionInterface';
import { BuilderInterface } from './BuilderInterface';

export class ComponentBuilder implements BuilderInterface {
  private currentId = 0;

  private readonly components: ComponentInterface[] = [];

  addItem(title: string, parentId: number): number {
    return this.addComponent(new Item(title), parentId);
  }

  addSection(title: string, parentId: number): number {
    return this.addComponent(new Section(new Item(title)), parentId);
  }

  getProduct(): ComponentInterface {
    return this.components[0]!;
  }

  private addComponent(component: ComponentInterface, parentId: number): number {
    this.validate(parentId);

    if (parentId === -1) {
      this.components[this.currentId] = component;

      return this.currentId++;
    }

    const section = this.components[parentId] as SectionInterface;
    section.addComponent(component);

    this.components[this.currentId] = component;

    return this.currentId++;
  }

  private validate(parentId: number): void {
    if (parentId === -1 && this.components.length > 0) {
      throw new Error('Duplicated root');
    }

    if (parentId >= 0 && this.components[parentId] === undefined) {
      throw new Error('Invalid parentId');
    }

    if (this.components[parentId] instanceof Item) {
      throw new Error('Cannot add Item to another Item');
    }
  }
}
