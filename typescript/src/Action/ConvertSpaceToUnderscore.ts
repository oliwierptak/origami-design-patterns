import { ItemInterface } from '../Item/ItemInterface';
import { ActionInterface } from './ActionInterface';

export class ConvertSpaceToUnderscore implements ActionInterface {
  apply(item: ItemInterface): void {
    item.setTitle(this.replace(item.getTitle()));
  }

  private replace(value: string): string {
    return value.replace(/ /g, '_');
  }
}
