import { ActionInterface } from '../Action/ActionInterface';
import { DefaultAction } from '../Action/DefaultAction';
import { IteratorInterface } from '../IteratorInterface';
import { SectionInterface } from './SectionInterface';

export class SectionIterator implements IteratorInterface {
  private static readonly defaultAction = new DefaultAction();

  constructor(private readonly section: SectionInterface) {}

  iterate(sectionAction?: ActionInterface | null, itemAction?: ActionInterface | null): void {
    const resolvedSectionAction = sectionAction ?? SectionIterator.defaultAction;
    const resolvedItemAction = itemAction ?? SectionIterator.defaultAction;

    this.iterateOverSection(resolvedSectionAction);

    for (const component of this.section.getComponents()) {
      component.iterate(resolvedSectionAction, resolvedItemAction);
    }
  }

  private iterateOverSection(sectionAction: ActionInterface): void {
    sectionAction.apply(this.section.getItem());
  }
}
