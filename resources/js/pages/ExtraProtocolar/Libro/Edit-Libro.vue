<template>
    <ModalRouterPage>
        <Content>
            <Head>
                <template v-slot:start>
                    <BtnBack
                        @click="
                            router.push(
                                configExtraProtocolar._LIBRO_.listar.path
                            )
                        "
                    />
                </template>
                <template v-slot:center>
                    <TitleTable>EDITAR LIBRO</TitleTable>
                </template>
            </Head>
            <div>
                <TabForm v-if="isReady" :formValues="formValues" @OnSubmit="onSubmit"/>
                <Skeleton v-if="!isReady" :tipo="2"/>
            </div>
        </Content>
    </ModalRouterPage>
</template>

<script setup lang="ts">
import {useRoute, useRouter} from "vue-router";
import {BtnBack, Content, Head, ModalRouterPage, Skeleton, TitleTable,} from "../../../components";
import {notify} from "@kyvg/vue3-notification";
import {onMounted, ref, toRefs} from "vue";
import {configExtraProtocolar} from "../../../router/ExtraProtocolar/ExtraProtocolarConfig";
import {useLibroStore} from "@/store/libro";
import {TabForm} from "@/pages/ExtraProtocolar/Libro/components";
import type {IFormFieldLibro, IlibrosLegalizados} from "@/pages/ExtraProtocolar/Libro/Interfaces/libro.interface";

const route = useRoute();
const router = useRouter();
const isReady = ref<boolean>(false);
const id = route.params.id.toString();
const {findLibroById, listarLibros, updateLibro} = useLibroStore();

const {isSubmit} = toRefs(useLibroStore());
const formValues = ref<IFormFieldLibro>();

const onSubmit = async (form: IFormFieldLibro) => {
    try {
        isSubmit.value = true;
        const {status, message} = await updateLibro(id, form);

        if (status) {
            notify({
                title: "Exito",
                text: message,
            });
            await router.push(configExtraProtocolar._LIBRO_.listar.path);
            await listarLibros();
        }
    } catch (error) {
    } finally {
        setTimeout(() => {
            isSubmit.value = false;
        }, 1300);
    }
};

const getLibro = async () => {
    isSubmit.value = true;
    try {
        const {libro, status} = await findLibroById(id.toString());
        if (status) {
            if (libro.length) {
                let libros_legalizados: IlibrosLegalizados[] = []
              
                for (let i = 0; i < libro.length; i++) {
                    libros_legalizados.push(
                        {
                            id: libro[i].s_libro,
                            libro: libro[i].s_libro.toString(),
                            cantidad: libro[i].s_cantidad,
                            folios: libro[i].s_folios ? parseInt(libro[i].s_folios ?? '0') : 0,
                            denominado: libro[i].s_denominacion,
                            formas: libro[i].s_forma,
                            precios: libro[i].s_precio ?? null,
                            numero: libro[i].s_numero_libro ? parseInt(libro[i].s_numero_libro) : null,
                        }
                    )
                }

                formValues.value = {
                    isEdit: true,
                    observacion: libro[0].s_observacion ?? '',
                    contado: !!libro[0].i_tipopago,
                    dni: libro[0].solicitante?.s_num_doc ? parseInt(libro[0].solicitante?.s_num_doc) : null,
                    dni_representa: libro[0].representante?.s_num_doc ? parseInt(libro[0].representante?.s_num_doc) : null,
                    ruc: libro[0].empresa?.s_num_doc ? parseInt(libro[0].empresa?.s_num_doc) : null,
                    ruc_facturado: libro[0].facturado?.s_num_doc ? parseInt(libro[0].facturado?.s_num_doc) : null,
                    correo: libro[0].solicitante?.correo ?? '',
                    telefono: libro[0].solicitante?.s_celular ? parseInt(libro[0].solicitante?.s_celular) : null,
                    libros_legalizados: libros_legalizados,
                    nombre: libro[0].solicitante?.nombre ?? '',
                    paterno: libro[0].solicitante?.s_paterno ?? '',
                    materno: libro[0].solicitante?.s_materno ?? '',
                    ruc_facturado_id_cod: libro[0].facturado?.s_codigo ?? '',
                    dni_representa_id_cod: libro[0].representante?.s_codigo ?? '',
                    dni_id_cod: libro[0].s_cliente ?? '',
                    ruc_id_cod: libro[0].empresa?.s_codigo ?? '',
                    razon_social: libro[0].empresa?.s_nombre ?? '',
                    persona_natural: libro[0].representante?.nombre_compuesto ?? '',
                    razon_social2: libro[0].facturado?.s_nombre ?? '',
                    files: libro[0]?.files,
                }
                isReady.value = status
            }


        }
    } catch (e) {
        isSubmit.value = false;
    } finally {
        isSubmit.value = false;
    }
};

onMounted(() => {
    getLibro();
});
</script>
