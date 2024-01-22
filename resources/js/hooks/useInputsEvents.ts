
export function  useInputsEvents(){
    const onFocusInput = (id: string) => {
       document?.getElementById(id)?.focus();
       return true
    }

    const blockKeyboardDelete = (event) => {
        if (event.key === 'Delete' || event.key === 'Backspace'   || event.keyCode === 8 || event.keyCode === 46) {
            event.preventDefault();
        }
    }

    return { onFocusInput, blockKeyboardDelete }
}

