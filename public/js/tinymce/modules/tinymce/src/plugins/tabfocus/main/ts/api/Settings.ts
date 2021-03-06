/**
 * Copyright (c) Tiny Technologies, Inc. All rights reserved.
 * Licensed under the LGPL or a commercial license.
 * For LGPL see License.txt in the project root for license information.
 * For commercial licenses see https://www.tiny.cloud/
 */

import Editor from 'tinymce/core/api/Editor';

const getTabFocusElements = (editor: Editor): string =>
  editor.getParam('tabfocus_elements', ':prev,:next');

const getTabFocus = (editor: Editor): string =>
  editor.getParam('tab_focus', getTabFocusElements(editor));

export {
  getTabFocus
};
