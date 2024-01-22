
const validateExtensionImages = (name = "") => {
    let extension = name ? name.substring(name.lastIndexOf(".") + 1) : "";
    switch (extension) {
        case "png":
            return true;
        case "PNG":
            return true;
        case "JPEG":
            return true;
        case "JPG":
            return true;
        case "jpg":
            return true;

        default:
            return false;
    }
};


/** @id getElementById */
const createBase64Image = async (id = "") => {
    return new Promise((resolve, reject) => {
        const fileInput = document.getElementById(id);

        /* @ts-ignore */
        const file = fileInput?.files[0];
        if (!file) {
            reject("No se seleccionó ningún archivo.");
            return;
        }

        const reader = new FileReader();

        reader.onload = () => {
            const base64String = reader.result
            /* @ts-ignore */
            //?.replace("data:", "")
            // ?.replace(/^.+,/, "");
            resolve(base64String);
        };

        reader.onerror = () => {
            reject("Error al leer el archivo como base64.");
        };

        reader.readAsDataURL(file);
    });
};


const createBase64ImageFromFile = (file = null) => {
    return new Promise((resolve, reject) => {
        /* @ts-ignore */
        const reader = new FileReader();

        reader.onload = () => {
            const base64String = reader.result
            /* @ts-ignore */
            //?.replace("data:", "")
            // ?.replace(/^.+,/, "");
            resolve(base64String);
        };

        reader.onerror = reject;

        if (file) {
            reader.readAsDataURL(file);
        } else {
            reject("No se proporcionó un archivo válido.");
        }
    });
};
const createBase64File = async (id = "") => {
    return new Promise((resolve, reject) => {
        const fileInput = document.getElementById(id);

        /* @ts-ignore */
        const file = fileInput?.files[0];
        if (!file) {
            reject("No se seleccionó ningún archivo.");
            return;
        }

        const reader = new FileReader();

        reader.onload = () => {
            const base64String = reader.result;
            resolve(base64String);
        };

        reader.onerror = () => {
            reject("Error al leer el archivo como base64.");
        };

        reader.readAsDataURL(file);
    });
};

export { validateExtensionImages, createBase64Image, createBase64File, createBase64ImageFromFile };
