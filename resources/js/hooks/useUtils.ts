export const useOnScrollMoveTo = (refs: HTMLElement | undefined, time: number = 600) => {
    setTimeout(() => {
        const inputElement = refs;
        if (inputElement) {
            inputElement.scrollIntoView({behavior: 'smooth', block: 'center'});
        }
    }, time)
}


export const useOpenModal = (hash: string) => {
    return (window.location.hash = "#" + hash);
};
export const useCloseModal = () => {
    return (window.location.hash = "#");
};

export const useGenerateKeyRandom = () => {
    return Math.random().toString(36).substring(7);
};

export const useFileOpenAction = (id: string) => {
    const inputelement: HTMLInputElement | null = document.getElementById(
        id
    ) as HTMLInputElement;
    if (inputelement) {
        return inputelement.click();
    }
};

export const useGetOnlyFileSelected = (id: string) => {
    const fileInput: HTMLInputElement | null = document.getElementById(
        id
    ) as HTMLInputElement;
    if (fileInput) {
        const files: FileList | null = fileInput.files;
        if (files) {
            return files[0];
        }
    }

    return null;
};

export const useDownloadFile = (name: string, ext: string, data: any) => {
    let blob = new Blob([data], {type: "application/octet-stream"});
    let downloadLink = URL.createObjectURL(blob);
    let a = document.createElement("a");
    a.href = downloadLink;
    let nowTime = new Intl.DateTimeFormat('es-ES', {year: 'numeric', month: 'long', day: 'numeric', hour: "numeric", minute: "numeric"})
    a.download = name + '-' + nowTime.format(new Date()) + ext;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(downloadLink);
};

export const isURL = (text: string) => {
    let expReg = /^(ftp|http|https):\/\/[^ "]+$/;
    return expReg.test(text);
}
