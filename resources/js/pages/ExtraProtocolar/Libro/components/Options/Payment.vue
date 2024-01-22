<template>
  <Modal :id="idModalPayment" position="modal-bottom">
    <div v-if="bookSelected">
      <button @click="useCloseModal()" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
      <h3 class="font-bold text-lg">Detalle de Recibo  {{bookSelected.s_libro}} </h3>
      <p class="py-4">Recibos de Pago</p>
      <Table>
        <THead>
        <tr>
          <th scope="col" class=" ">Fecha</th>
          <th scope="col" class=" ">Facturado</th>
          <th scope="col" class=" ">Documento</th>
          <th scope="col" class=" ">Numero</th>
          <th scope="col" class=" ">SubTotal</th>
          <th scope="col" class=" ">IGV</th>
          <th scope="col" class=" ">Total</th>
        </tr>
        </THead>
        <tbody>
        <tr
            v-if="bookSelected?.detalle_recibo?.recibo_pago"
            class="cursor-pointer  hover:bg-base-300"

        >
          <td
          >
            {{ bookSelected?.d_fecha_apertura }}
          </td>
          <td
          >
            {{ bookSelected?.facturado?.nombre_compuesto }}
          </td>
          <td
          >
            {{ bookSelected?.facturado?.s_num_doc }}
          </td>
          <td
          >
            {{ bookSelected?.facturado?.s_num_doc }}
          </td>
          <td
          >
            {{ bookSelected?.detalle_recibo?.recibo_pago?.de_subTotal }}
          </td>
          <td
          >
            {{ bookSelected?.detalle_recibo?.recibo_pago?.de_igv }}
          </td>
          <td
          >
            {{ bookSelected?.detalle_recibo?.recibo_pago?.de_total }}
          </td>
        </tr>
        </tbody>
      </Table>
      <p class="py-4">Detalle de Recibo</p>
      <Table>
        <THead>
        <tr>

          <th scope="col" class=" ">Detalle</th>
          <th scope="col" class=" ">Precio</th>
          <th scope="col" class=" ">Cantidad</th>
          <th scope="col" class=" ">Total</th>
        </tr>
        </THead>
        <tbody>
        <tr v-if="bookSelected?.detalle_recibo"

            class="cursor-pointer  hover:bg-base-300"

        >
          <td
          >
            {{ bookSelected.detalle_recibo.s_detalle }}
          </td>
          <td
          >
            {{ bookSelected.detalle_recibo.de_precio }}
          </td>


          <td
          >
            {{ bookSelected.detalle_recibo.i_cantidad }}
          </td>
          <td
          >
            {{ bookSelected.detalle_recibo.de_total }}
          </td>


        </tr>
        </tbody>
      </Table>
      <p class="py-4">Pagos a Cuenta</p>
      <Table>
        <THead>
        <tr>
          <th scope="col" class=" ">Referencia</th>
          <th scope="col" class=" ">Fecha</th>
          <th scope="col" class=" ">Detalle</th>
          <th scope="col" class=" ">A Cuenta</th>
        </tr>
        </THead>
        <tbody>
        <tr

            class="cursor-pointer  hover:bg-base-300"

        >
          <td
          >

          </td>
        </tr>
        </tbody>
      </Table>
    </div>
  </Modal>
</template>
<script setup lang="ts">
import {useCloseModal} from "@/hooks/useUtils";
import {Modal, Table, THead} from "@/components";
import {type PropType, toRefs} from "vue";
import type {Libro} from "@/models/types";

const props = defineProps({
  idModalPayment: {
    require: true,
    type: String,
  },
  bookSelected: {
    require: true,
    type: Object as PropType<Libro>,
  }
})

const { bookSelected } = toRefs(props)

</script>
