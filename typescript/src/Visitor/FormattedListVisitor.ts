import { ItemInterface } from '../Item/ItemInterface';
import { SectionInterface } from '../Section/SectionInterface';
import { VisitorInterface } from './VisitorInterface';

export class FormattedListVisitor implements VisitorInterface {
  private readonly lines: string[] = [];

  private indent = '';

  getResult(): string[] {
    return this.lines;
  }

  visitItem(item: ItemInterface): void {
    this.lines.push(this.indent + item.getTitle());
  }

  visitSection(section: SectionInterface): void {
    const currentIndent = this.indent;
    this.lines.push(this.indent + section.getItem().getTitle());

    for (const component of section.getComponents()) {
      this.indent = `${currentIndent}  `;
      component.accept(this);
    }

    this.indent = currentIndent;
  }
}
