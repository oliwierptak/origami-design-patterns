import { ActionInterface } from '../Action/ActionInterface';
import { ComponentInterface } from '../ComponentInterface';
import { ItemInterface } from '../Item/ItemInterface';
import { VisitorInterface } from '../Visitor/VisitorInterface';
import { SectionInterface } from './SectionInterface';
import { SectionIterator } from './SectionIterator';

export class Section implements SectionInterface {
  private readonly components: ComponentInterface[] = [];

  constructor(private readonly item: ItemInterface) {}

  getItem(): ItemInterface {
    return this.item;
  }

  accept(visitor: VisitorInterface): void {
    visitor.visitSection(this);
  }

  iterate(sectionAction?: ActionInterface | null, itemAction?: ActionInterface | null): void {
    new SectionIterator(this).iterate(sectionAction, itemAction);
  }

  addComponent(component: ComponentInterface): void {
    this.components.push(component);
  }

  getComponents(): ComponentInterface[] {
    return this.components;
  }
}
