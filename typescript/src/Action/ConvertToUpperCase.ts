import { ItemInterface } from '../Item/ItemInterface';
import { ActionInterface } from './ActionInterface';

export class ConvertToUpperCase implements ActionInterface {
  apply(item: ItemInterface): void {
    item.setTitle(this.convert(item.getTitle()));
  }

  private convert(value: string): string {
    return value.toLocaleUpperCase();
  }
}
