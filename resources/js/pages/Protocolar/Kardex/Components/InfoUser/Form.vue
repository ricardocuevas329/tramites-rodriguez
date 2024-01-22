<template>
    <ScrollView>
        <Row>
            <LabelInput>N° Documento</LabelInput>
            <TextInputNumber :showLabel="false"/>
        </Row>
        <Row>
            <LabelInput>Correo</LabelInput>
            <TextInputNumber :showLabel="false"/>
        </Row>
        <Row>
            <LabelInput>Celular</LabelInput>
            <TextInputNumber :showLabel="false"/>
        </Row>
        <Row>
            <LabelInput>Corporativo/Referencia</LabelInput>
            <TextInputNumber :showLabel="false"/>
        </Row>
    </ScrollView>
</template>
<script setup lang="ts">
import {LabelInput, Row, ScrollView, TextInputNumber} from "@/components";
</script>
