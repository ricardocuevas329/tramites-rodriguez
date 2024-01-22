import { configReporte as Config } from "./ReportConfig";

const routerReporte = [
    {
        ...Config._REPORTE_.listar,
        meta: {
            isMenu: true,
        },
        component: () =>
            import(
                `../../pages/${Config._REPORTE_.folder}/${Config._REPORTE_.page}/${Config._REPORTE_.listar.file}.vue`
            ),
    },
];

export default routerReporte;
