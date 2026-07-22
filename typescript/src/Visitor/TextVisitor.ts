import { ItemInterface } from '../Item/ItemInterface';
import { SectionInterface } from '../Section/SectionInterface';
import { VisitorInterface } from './VisitorInterface';

export class TextVisitor implements VisitorInterface {
  private result = '';

  private indent = '';

  getResult(): string {
    return this.result.trim();
  }

  visitItem(item: ItemInterface): void {
    this.result += `${item.getTitle()} `;
  }

  visitSection(section: SectionInterface): void {
    const currentIndent = this.indent;
    this.result += `\n ${this.indent}> ${section.getItem().getTitle()} | `;

    for (const component of section.getComponents()) {
      this.indent = `${currentIndent}  `;
      component.accept(this);
    }

    this.indent = currentIndent;
  }
}
