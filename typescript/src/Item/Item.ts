import { ActionInterface } from '../Action/ActionInterface';
import { VisitorInterface } from '../Visitor/VisitorInterface';
import { ItemInterface } from './ItemInterface';
import { ItemIterator } from './ItemIterator';

export class Item implements ItemInterface {
  constructor(private title: string) {}

  setTitle(value: string): void {
    this.title = value;
  }

  accept(visitor: VisitorInterface): void {
    visitor.visitItem(this);
  }

  getTitle(): string {
    return this.title;
  }

  iterate(sectionAction?: ActionInterface | null, itemAction?: ActionInterface | null): void {
    new ItemIterator(this).iterate(sectionAction, itemAction);
  }
}
