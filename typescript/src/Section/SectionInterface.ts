import { ComponentInterface } from '../ComponentInterface';
import { ItemInterface } from '../Item/ItemInterface';

export interface SectionInterface extends ComponentInterface {
  getItem(): ItemInterface;
  addComponent(component: ComponentInterface): void;
  getComponents(): ComponentInterface[];
}
