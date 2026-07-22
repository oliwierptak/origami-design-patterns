import { ItemInterface } from '../Item/ItemInterface';
import { SectionInterface } from '../Section/SectionInterface';

export interface VisitorInterface {
  visitItem(item: ItemInterface): void;
  visitSection(section: SectionInterface): void;
}
