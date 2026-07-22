import { ItemInterface } from '../Item/ItemInterface';

export interface ActionInterface {
  apply(item: ItemInterface): void;
}
