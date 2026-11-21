import { onMounted, onUnmounted } from 'vue';

interface CheatCodeOptions {
    /**
     * Через сколько миллисекунд сбрасывать незавершённую комбинацию.
     */
    timeout?: number;

    /**
     * Разрешить ввод чит-кода внутри input и textarea.
     */
    allowInInputs?: boolean;

    /**
     * Использовать физические клавиши через event.code.
     */
    usePhysicalKeys?: boolean;
}

export function useCheatCode(
    sequence: string[],
    onActivated: () => void,
    options: CheatCodeOptions = {},
) {
    const {
        timeout = 2000,
        allowInInputs = false,
        usePhysicalKeys = false,
    } = options;

    const expectedSequence = sequence.map(normalizeKey);

    let enteredSequence: string[] = [];
    let resetTimer: number | undefined;

    function normalizeKey(key: string): string {
        return key.toLowerCase();
    }

    function reset(): void {
        enteredSequence = [];

        if (resetTimer !== undefined) {
            window.clearTimeout(resetTimer);
            resetTimer = undefined;
        }
    }

    function isEditableElement(target: EventTarget | null): boolean {
        if (!(target instanceof HTMLElement)) {
            return false;
        }

        return target.matches(
            'input, textarea, select, [contenteditable="true"]',
        );
    }

    function handleKeydown(event: KeyboardEvent): void {
        // Не учитываем автоматическое повторение при удерживании клавиши.
        if (event.repeat) {
            return;
        }

        // Чтобы чит-код не срабатывал, пока пользователь печатает в форме.
        if (!allowInInputs && isEditableElement(event.target)) {
            reset();
            return;
        }

        const pressedKey = normalizeKey(
            usePhysicalKeys ? event.code : event.key,
        );

        enteredSequence.push(pressedKey);

        // Храним только нужное количество последних клавиш.
        if (enteredSequence.length > expectedSequence.length) {
            enteredSequence.shift();
        }

        const combinationMatched =
            enteredSequence.length === expectedSequence.length &&
            enteredSequence.every(
                (key, index) => key === expectedSequence[index],
            );

        if (combinationMatched) {
            reset();
            onActivated();
            return;
        }

        window.clearTimeout(resetTimer);

        resetTimer = window.setTimeout(() => {
            reset();
        }, timeout);
    }

    onMounted(() => {
        window.addEventListener('keydown', handleKeydown);
    });

    onUnmounted(() => {
        window.removeEventListener('keydown', handleKeydown);
        reset();
    });

    return {
        reset,
    };
}
