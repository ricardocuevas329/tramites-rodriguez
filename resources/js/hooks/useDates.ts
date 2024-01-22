import { ref } from "vue";

export function useDate() {
    const today = ref<string>("");
    const todayDefault = ref<string>("");

    const currentDate = () => {
        const fecha = new Date();
        const formato = new Intl.DateTimeFormat("es-ES", {
            day: "2-digit",
            month: "2-digit",
            year: "numeric",
        });

        const formatDateDefault = new Intl.DateTimeFormat("fr-CA", {
            year: "numeric",
            month: "2-digit",
            day: "2-digit",
        });
        todayDefault.value = formatDateDefault.format(new Date())
        return (today.value = formato.format(fecha));
    };

    const currentDateMax = (year: number) => {
        const dateCurrent = new Date();
        //  new Date().toISOString().split('T')[0];
        const formatDate = new Intl.DateTimeFormat("fr-CA", {
            year: "numeric",
            month: "2-digit",
            day: "2-digit",
        });
        dateCurrent.setFullYear(dateCurrent.getFullYear() - year);
        return formatDate.format(dateCurrent);
    };

    const formatDateDefault = (date: string|null = null, human: boolean = true) => {
        let formatter
        if(human){
            formatter = new Intl.DateTimeFormat('es-ES',  { year: 'numeric', month: 'long', day: 'numeric', weekday: 'long' });
        }else{
            formatter = new Intl.DateTimeFormat('es-ES',  { year: '2-digit', month: '2-digit',  day: '2-digit', hour:'2-digit', minute:'2-digit'});
        }
        if(date){
            return  formatter.format(new Date(date));
        }
    }

    const formatDateFR = (date: string) => {
            let partDate = date.split("/");
            let formatDateNew = new Date(Number(partDate[2]), Number(partDate[1]) - 1, Number(partDate[0]));
            return formatDateNew.toISOString().split('T')[0];
    }


    currentDate();

    return { todayDefault, today, formatDateFR, currentDateMax, formatDateDefault };
}

export function useCalculateAge(happyBirthday: string) {
    if (happyBirthday) {
        var hoy = new Date();
        var dateHappyBirthday = new Date(happyBirthday);
        var edad = hoy.getFullYear() - dateHappyBirthday.getFullYear();
        var mes = hoy.getMonth() - dateHappyBirthday.getMonth();
        if (mes < 0 || (mes === 0 && hoy.getDate() < dateHappyBirthday.getDate())) {
            edad--;
        }
        return edad.toString();
    }
}
