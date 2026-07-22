import { IteratorInterface } from './IteratorInterface';
import { VisitorInterface } from './Visitor/VisitorInterface';

export interface ComponentInterface extends IteratorInterface {
  accept(visitor: VisitorInterface): void;
}
