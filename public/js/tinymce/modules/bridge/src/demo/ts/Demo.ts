import { registerDemoButtons } from './buttons/ButtonDemo';
import { getDemoRegistry } from './buttons/DemoRegistry';
import { createAlertBannerDialog } from './dialogs/AlertBannerDialog';
import { createAnchorDialog } from './dialogs/AnchorDialog';
import { createCharmapDialog } from './dialogs/CharmapDialog';
import { createCodeDialog } from './dialogs/CodeDialog';
import { createCodeSampleDialog } from './dialogs/CodeSampleDialog';
import { createColorPickerDialog } from './dialogs/ColorPickerDialog';
import { createDocumentPropsDialog } from './dialogs/DocumentPropsDialog';
import { createFindReplaceDialog } from './dialogs/FindReplaceDialog';
import { createImageDialog } from './dialogs/ImageDialog';
import { createLinkDialog } from './dialogs/LinkDialog';
import { createMediaDialog } from './dialogs/MediaDialogDemo';
import { createPreviewDialog } from './dialogs/PreviewDialog';
import { createTableCellDialog } from './dialogs/TableCellDialog';
import { createTableDialog } from './dialogs/TableDialog';
import { createTableRowDialog } from './dialogs/TableRowDialog';
import { createTemplateDialog } from './dialogs/TemplateDialog';
import { createWordcountDialog } from './dialogs/WordcountDialog';
import { registerDemoContextMenus } from './menus/ContextMenuDemo';
import { registerDemoMenuItems } from './menus/MenuItemDemo';

createAlertBannerDialog();
createAnchorDialog();
createCharmapDialog();
createCodeDialog();
createCodeSampleDialog();
createColorPickerDialog();
createDocumentPropsDialog();
createFindReplaceDialog();
createImageDialog();
createLinkDialog();
createMediaDialog();
createPreviewDialog();
createPreviewDialog();
createTableCellDialog();
createTableDialog();
createTableRowDialog();
createTemplateDialog();
registerDemoButtons();
registerDemoMenuItems();
registerDemoContextMenus();
createWordcountDialog();

// eslint-disable-next-line no-console
console.log(getDemoRegistry().getAll());
