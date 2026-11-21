/**
 * This function is same as PHP's nl2br() with default parameters.
 *
 * @param {string} str Input text
 * @param {boolean} replaceMode Use replace instead of insert
 * @param {boolean} isXhtml Use XHTML
 * @return {string} Filtered text
 */
export function nl2br (str: string, replaceMode: boolean = true, isXhtml: boolean = true): string {
    const breakTag = isXhtml ? '<br />' : '<br>';
    const replaceStr = replaceMode ? '$1' + breakTag : '$1' + breakTag + '$2';

    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, replaceStr);
}

/**
 * This function inverses text from PHP's nl2br() with default parameters.
 *
 * @param {string} str Input text
 * @param {boolean} replaceMode Use replace instead of insert
 * @return {string} Filtered text
 */
export function br2nl (str: string, replaceMode: boolean = true): string {
    const replaceStr = (replaceMode) ? "\n" : '';

    // Includes <br>, <BR>, <br />, </br>
    return str.replace(/<\s*\/?br\s*[\/]?>/gi, replaceStr);
}
