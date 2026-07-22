import { ComponentInterface } from '../ComponentInterface';

export interface BuilderInterface {
  addSection(title: string, parentId: number): number;
  addItem(title: string, parentId: number): number;
  getProduct(): ComponentInterface;
}
