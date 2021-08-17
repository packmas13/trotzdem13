<template>
    <div v-if="!handover" class="flex justify-between">
        <button
            class="text-sm secondary-button font-normal border-0 p-1"
            type="button"
            @click="displayFormModal = true"
        >
            Übergabedatum eingeben
        </button>
        <button
            class="text-sm text-link"
            type="button"
            @click="displayDetailModal = true"
        >
            Details
        </button>
    </div>
    <div v-else class="flex justify-between items-center">
        <span class="text-gray-600">
            <small>kriegt das Banner </small>
            <span
                v-if="has_many_variants"
                class="text-white px-1 mx-1"
                :class="handover.variant % 2 ? 'bg-teal-700' : 'bg-mango-700'"
                >{{ handover.variant }}</span
            >
            <small>am</small>
            <strong class="text-teal-700">&nbsp;{{ handover_at }}</strong>
        </span>
        <button
            class="text-sm secondary-button font-normal border-0 p-1"
            type="button"
            @click="displayFormModal = true"
        >
            ändern
        </button>
        <button
            class="text-sm text-link"
            type="button"
            @click="displayDetailModal = true"
        >
            Details
        </button>
    </div>
    <DialogModal v-if="displayFormModal">
        <form @submit.prevent="submit">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3
                            class="text-lg leading-6 font-medium text-gray-900"
                            id="modal-title"
                        >
                            Wann soll die Gruppe
                            <strong>{{ team.name }}</strong> das Banner kriegen?
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
                        <div v-if="has_many_variants" class="mt-2">
                            <label class="col-span-6 sm:col-span-4">
                                <RadioInput
                                    label="Welches Banner?"
                                    :required="true"
                                    :options="banner_variants"
                                    v-model="variant"
                                    v-slot="{ option }"
                                >
                                    Banner {{ option }}
                                </RadioInput>
                            </label>
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
                    @click="displayFormModal = false"
                >
                    Abbrechen
                </button>
            </div>
        </form>
    </DialogModal>
    <DialogModal v-if="displayDetailModal">
        <div class="p-5">
            <TeamDetail :team="team"></TeamDetail>
        </div>
        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
            <button
                type="button"
                class="secondary-button"
                @click="displayDetailModal = false"
            >
                Schließen
            </button>
        </div>
    </DialogModal>
</template>

<script>
import DialogModal from "../../../components/DialogModal.vue";
import RadioInput from "../../../input/RadioInput.vue";
import TeamDetail from "../team/_Show.vue";

export default {
    components: { DialogModal, TeamDetail, RadioInput },
    props: {
        team: {
            type: Object,
        },
    },
    data() {
        const handover = this.team.handover;

        let variant;
        if (handover) {
            variant = handover.variant;
        } else if (this.team.banner.variants == 1) {
            variant = 1;
        }

        return {
            displayFormModal: false,
            displayDetailModal: false,
            received_at: handover ? handover.received_at : null,
            variant,
            handover,
        };
    },
    computed: {
        has_many_variants() {
            return this.team.banner.variants > 1;
        },
        banner_variants() {
            const options = {};
            for (let i = 1; i <= this.team.banner.variants; i++) {
                options[i] = i;
            }
            return options;
        },
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
                variant: this.variant,
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
                        this.displayFormModal = false;
                    });
            }
            axios
                .post(this.route("app.orga.handover.store"), form)
                .then((r) => {
                    this.handover = r.data;
                    this.displayFormModal = false;
                });
        },
    },
};
</script>
