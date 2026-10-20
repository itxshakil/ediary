import assert from 'node:assert/strict';
import { test } from 'node:test';

import { initTimezoneFields } from '../../resources/js/modules/timezone.js';

test('fills every timezone field with the browser timezone', () => {
    const fields = [{ value: '' }, { value: '' }];
    globalThis.document = { querySelectorAll: (selector) => (selector === 'input[data-timezone]' ? fields : []) };

    initTimezoneFields();

    const expected = Intl.DateTimeFormat().resolvedOptions().timeZone;
    assert.deepEqual(fields.map((field) => field.value), [expected, expected]);
});
