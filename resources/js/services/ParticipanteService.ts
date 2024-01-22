const IdRepresentant = 6;
export const ParticipanteItems = [
    {
        id: 1,
        label: "PADRE",
    },
    {
        id: 2,
        label: "MADRE",
    },
    {
        id: 3,
        label: "HIJO",
    },
    /*{
        id: 4,
        label: "CLIENTE",
    },
    {
        id: 5,
        label: "SOLICITANTE",
    },*/
    {
        id: IdRepresentant,
        label: "REPRESENTANTE",
    }
];

export const getParticipanteItem = {
    1: "PADRE",
    2: "MADRE",
    3: "HIJO",
    /*4: "CLIENTE",
    5: "SOLICITANTE",*/
    6: "REPRESENTANTE"
};

export const VALID_PARTICPANT_REPRESENTANTE = IdRepresentant;
