import { ItemInterface } from '../Item/ItemInterface';
import { ActionInterface } from './ActionInterface';

export class DefaultAction implements ActionInterface {
  apply(item: ItemInterface): void {
    void item;
  }
}
