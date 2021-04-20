<template>
    <div v-if="!handover" class="text-right">
        <button
            class="text-sm secondary-button font-normal border-0 p-1"
            type="button"
            @click="showModal = true"
        >
            Übergabedatum eingeben
        </button>
    </div>
    <div v-else class="flex justify-between items-center">
        <span class="text-gray-600">
            <small>kriegt das Banner am</small>
            <strong class="text-teal-700">&nbsp;{{ handover_at }}</strong>
        </span>
        <button
            class="text-sm secondary-button font-normal border-0 p-1"
            type="button"
            @click="showModal = true"
        >
            ändern
        </button>
    </div>
    <div
        v-if="showModal"
        class="fixed z-10 inset-0 overflow-y-auto"
        aria-labelledby="modal-title"
        role="dialog"
        aria-modal="true"
    >
        <div
            class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0"
        >
            <div
                class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                aria-hidden="true"
            ></div>

            <!-- This element is to trick the browser into centering the modal contents. -->
            <span
                class="hidden sm:inline-block sm:align-middle sm:h-screen"
                aria-hidden="true"
                >&#8203;</span
            >

            <form
                @submit.prevent="submit"
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
            >
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left"
                        >
                            <h3
                                class="text-lg leading-6 font-medium text-gray-900"
                                id="modal-title"
                            >
                                Wann soll die Gruppe
                                <strong>{{ team.name }}</strong> das Banner
                                kriegen?
                            </h3>
                            <div class="mt-2 text-center">
                                <input
                                    type="date"
                                    placeholder="Datum (JJJJ-MM-TT)"
                                    v-model="received_at"
                                    autofocus
                                    required
                                />
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse"
                >
                    <button type="submit" class="primary-button ml-3">
                        Speichern
                    </button>
                    <button
                        type="button"
                        class="secondary-button"
                        @click="showModal = false"
                    >
                        Abbrechen
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        team: {
            type: Object,
        },
    },
    data() {
        const handover = this.team.handover;

        return {
            showModal: false,
            received_at: handover ? handover.received_at : null,
            handover,
        };
    },
    computed: {
        handover_at() {
            if (!this.handover) {
                return null;
            }
            const d = new Date(this.received_at);
            return d.toLocaleDateString("de-DE", {
                day: "numeric",
                month: "long",
            });
        },
    },
    methods: {
        submit() {
            const form = {
                team_id: this.team.id,
                banner_id: this.team.banner_id,
                received_at: this.received_at,
            };
            if (this.handover) {
                return axios
                    .put(
                        this.route(
                            "app.orga.handover.update",
                            this.handover.id
                        ),
                        form
                    )
                    .then((r) => {
                        this.handover = r.data;
                        this.showModal = false;
                    });
            }
            axios
                .post(this.route("app.orga.handover.store"), form)
                .then((r) => {
                    this.handover = r.data;
                    this.showModal = false;
                });
        },
    },
};
</script>
