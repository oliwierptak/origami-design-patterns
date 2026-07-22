import { ActionInterface } from '../Action/ActionInterface';
import { IteratorInterface } from '../IteratorInterface';
import { ItemInterface } from './ItemInterface';

export class ItemIterator implements IteratorInterface {
  constructor(private readonly item: ItemInterface) {}

  iterate(sectionAction?: ActionInterface | null, itemAction?: ActionInterface | null): void {
    void sectionAction;
    itemAction?.apply(this.item);
  }
}
