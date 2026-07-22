import { ActionInterface } from './Action/ActionInterface';

export interface IteratorInterface {
  iterate(sectionAction?: ActionInterface | null, itemAction?: ActionInterface | null): void;
}
