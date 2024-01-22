export const RegExps = {
    compositeName: /^(?:[A-Za-zÀ-ÖØ-öø-ÿ]+(?: [A-Za-zÀ-ÖØ-öø-ÿ]+)*)?$/,
    isNumeric: /^-?\d+$/,
    isDate: /^([0-2][0-9]|3[0-1])(\/|-)(0[1-9]|1[0-2])\2(\d{4})$/,
    isUrl: /^https?:\/\/[\w\-]+(\.[\w\-]+)+[*#?]?.*$/,
    isDecimal: /^\d*\.\d+$/,
    check: /^(?!.*(?:admin|password|123|1234|456|789|aeiou|abcdef|qawsed|qaws|qaw|azs))/,
    password_secure: /^(?=(?:.*\d))(?=.*[A-Z])(?=.*[a-z])(?=.*[.,*!?¿¡/#$%&])\S{8,64}$/,
    isPositive: /^[0-9]*\.?[0-9]+$/
 };

export const validateMaxDigits = (value, max: number) => {
    const digitCount = String(value).replace(/\D/g, "").length;
    return digitCount <= max;
}

export const validateMinDigits = (value, max: number) => {
    const digitCount = String(value).replace(/\D/g, "").length;
    return digitCount == max;
}

