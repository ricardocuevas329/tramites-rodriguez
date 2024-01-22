<template>
  <Modal position="modal-top justify-center py-4" :id="idModalReport">
    <button v-if="!isPrinted" @click="useCloseModal()" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">
      ✕
    </button>

    <div :id="idContentPrint" class="max-w-full mx-4 text-xs" v-if="books.length">
      <div>
        <div class="flex">
          <div class="avatar mb-4">
            <div class="w-5 rounded-xl">
              <img :src="configuracion.s_ruta_logo"/>
            </div>
          </div>
          <p class="mx-2"> {{ configuracion.s_empresa }} | Reporte Libro</p>
        </div>
        <h1 class="mt-2"></h1>
      </div>
      <div class="mx-4 my-4">
        <div class="my-4 flex justify-between  ">
          <p>
            {{ books[0].d_fecha_apertura }}
          </p>
          <p>
            {{ books[0].s_libro }}
          </p>
        </div>
        <div class="my-10">
          <Row class="gap-2">
            <p>{{ books[0].cliente?.nombre_compuesto }}</p>
            <p v-if="books[0].d_fecha_cierre">{{ formatDateDefault(books[0].d_fecha_cierre, false) }}</p>
          </Row>
          <Row class="gap-2">
            <p>{{ books[0].empresa?.nombre_compuesto }}</p>
            <p>{{ books[0].s_codigo }}</p>
          </Row>
          <p class="text-center">{{ books[0].empresa?.s_email }}</p>
          <Row class="gap-2">
            <p>{{ books[0].facturado?.nombre_compuesto }}</p>
            <p>{{ books[0].facturado?.s_num_doc }}</p>
          </Row>
          <p class="text-center">{{ books[0].empresa?.s_direccion }}</p>
        </div>
        <div v-for="(item, k) in books" :key="k">
          <Row class="gap-2">
            <p>{{ item.s_libro }}</p>
            <p>{{ item.s_denominacion }}</p>
            <p>{{ item.s_cantidad }}</p>
            <p>{{ item.s_precio }}</p>
          </Row>
        </div>
        <div class="">
          <p>Total: {{ total }} </p>
          <br>
        </div>
      </div>

    </div>


    <Center v-if="!isPrinted" class="gap-2">
      <button @click="onDownloadPDF" class="btn btn-xs btn-error text-white">
        <FilePdfBox/>
        Descargar
      </button>

      <button @click="onDownloadImage" class="btn btn-xs btn-primary text-white">
        <Image/>
        Descargar
      </button>

      <button @click="imprimir" class="btn btn-xs btn-success text-white">
        <Printer/>
        Imprimir
      </button>
    </Center>

  </Modal>
</template>
<script setup lang="ts">


import html2canvas from "html2canvas";
import {jsPDF} from "jspdf";
import {useCloseModal, useGenerateKeyRandom} from "@/hooks/useUtils";
import FilePdfBox from "vue-material-design-icons/FilePdfBox.vue";
import {Center, Modal, Row} from "@/components";
import Printer from "vue-material-design-icons/Printer.vue";
import Image from "vue-material-design-icons/Image.vue";
import {type PropType, ref, toRefs, watchEffect} from "vue";
import type {Libro} from "@/models/types";
import {useDate} from "@/hooks/useDates";
import {useConfiguracionStore} from "@/store/configuracion";

const {configuracion} = toRefs(useConfiguracionStore());
const idContentPrint = useGenerateKeyRandom()
const isPrinted = ref<boolean>(false);
const {formatDateDefault} = useDate()
const total = ref<number>(0);
const nameFile = ref<string>('');
const props = defineProps({
  idModalReport: {
    require: true,
    type: String,
  },
  books: {
    require: true,
    type: Object as PropType<Libro[]>,
  },
  bookSelected: {
    require: true,
    type: Object as PropType<Libro>,
  }
})

const {bookSelected, books} = toRefs(props)


function imprimir() {
  isPrinted.value = true
  setTimeout(() => {
    onPrint()
  }, 300)
}

function onPrint() {

  const appContainer = document.getElementById('app');
  const contentPrinter = document.getElementById(idContentPrint);
  const elementHide = appContainer.querySelectorAll(':not(#contentPrinter)');
  elementHide.forEach(elemento => {
    elemento.style.display = 'none';
  });
  window.print();
  isPrinted.value = false


  elementHide.forEach(elemento => {
    elemento.style.display = '';
  });

}


function onDownloadImage() {
  const div = document.getElementById(idContentPrint);


  html2canvas(div, {
    removeContainer: true,
    scale: 3,
    useCORS: true,
    logging: true,
  }).then(canvas => {
    const url = URL.createObjectURL(canvas.toBlob(blob => {
      const enlaceDescarga = document.createElement('a');
      enlaceDescarga.href = URL.createObjectURL(blob);
      enlaceDescarga.download = nameFile.value + '.png';

      enlaceDescarga.click();

      URL.revokeObjectURL(url);
    }, 'image/png'));
  });
}

function onDownloadPDF() {
  const divToCapture = document.getElementById(idContentPrint);

  html2canvas(divToCapture, {
    removeContainer: true,
    scale: 3,
    useCORS: true,
    logging: true,
  }).then(function (canvas) {
    const width = canvas.width / 3.0;
    const height = canvas.height / 3.0;

    const pdf = new jsPDF({
      orientation: width > height ? 'landscape' : 'portrait',
      unit: 'mm',
      format: [width, height],
    });

    pdf.addImage(canvas.toDataURL("image/png", 1.0), "PNG", 0, 0, width, height);
    pdf.save(nameFile.value + ".pdf");
  });
}

watchEffect(() => {
  if (books.value.length && bookSelected.value) {
    total.value = books.value.reduce((total, producto) => {
      const precio = producto.s_precio ?? '0';
      const cantidad = producto.s_cantidad ?? 0;
      return total + (parseFloat(precio) * cantidad);
    }, 0);

    nameFile.value = bookSelected.value?.s_codigo + '-reporte-libro'

  }
})


</script>
<style media="print">
@media print {
  body {
    font-family: Arial, sans-serif;
  }

  .modal-box {
    box-shadow: none;
  }

  h1 {
    border-bottom: 1px solid #333;
  }

}
</style>
