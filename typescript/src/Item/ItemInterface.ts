import { ComponentInterface } from '../ComponentInterface';

export interface ItemInterface extends ComponentInterface {
  setTitle(value: string): void;
  getTitle(): string;
}
