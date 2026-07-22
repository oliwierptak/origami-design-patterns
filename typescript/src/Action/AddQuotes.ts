import { ItemInterface } from '../Item/ItemInterface';
import { ActionInterface } from './ActionInterface';

export class AddQuotes implements ActionInterface {
  apply(item: ItemInterface): void {
    item.setTitle(this.quote(item.getTitle()));
  }

  private quote(value: string): string {
    return `'${value}'`;
  }
}
