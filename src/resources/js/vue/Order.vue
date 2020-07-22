<template>
    <div class="order">
        <h1 class="mb-5">Форма заказа</h1>
        <form class="row" ref="order">
            <div v-if='errorMessage || orderId' class="col-md-12 mb-3">
                <div v-if='errorMessage'  class="alert alert-danger" role="alert">{{ errorMessage }}</div>
                <div v-if='orderId'  class="alert alert-primary" role="alert">
                    Ваш заказ №{{ orderId }} оформлен.
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label for="name">Имя получателя</label>
                <input id="name" class="form-control" name="name" placeholder="Алексей" type="text" />
                <span v-if="errorField.name" class="text-danger">{{ errorField.name[0] }}</span>
            </div>
            <div class="col-md-6 mb-3">
                <label for="phone">Контактный телефон</label>
                <input id="phone" class="form-control" name="phone" placeholder="+79110064400" type="tel" />
                <span v-if="errorField.phone" class="text-danger">{{ errorField.phone[0] }}</span>
            </div>
            <div class="col-md-12 mb-3">
                <label for="address">Адрес доставки</label>
                <input id="address" class="form-control" name="address" placeholder="Санкт-Петербург, Финляндский проспект, д. 4" type="tel" />
                <span v-if="errorField.address" class="text-danger">{{ errorField.address[0] }}</span>
            </div>
            <div class="col-md-6 mb-3">
                <label for="package">Тарифный план</label>
                <div class="order__loader-container">
                    <Select2 id="package"
                             class="vue-select2"
                             name="package"
                             v-model='packageSelect'
                             :disabled='loadPackage'
                             @change='changePackage(packageSelect)'
                    ></Select2>
                    <div class="order__loader" v-if='loadPackage'><i class="fas fa-spinner fa-spin"></i></div>
                </div>
                <span v-if="errorField.package" class="text-danger">{{ errorField.package[0] }}</span>
            </div>
            <div class="col-md-6 mb-3">
                <label for="delivery">Дата доставки</label>
                <div class="input-group order__loader-container">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <datePicker id="delivery"
                                class="form-control"
                                name="delivery"
                                placeholder="09.07.2020"
                                type="text"
                                :disabled="loadDelivery"
                                v-model="datePickerDate"
                                :config="datePickerOptions"
                                ref="delivery"
                    />
                    <div class="order__loader" v-if='loadDelivery'><i class="fas fa-spinner fa-spin"></i></div>
                </div>
                <span v-if="errorField.delivery" class="text-danger">{{ errorField.delivery[0] }}</span>
            </div>
            <div class="col-md-6">
                <div class="input-group mb-3">
                    <input id="price" class="form-control" name="price" type="text"  readonly :value="price" />
                    <div class="input-group-append">
                        <button class="btn btn-success" :disabled='loadDelivery || loadPackage || loadOrder' v-on:click='sendOrder'>Заказать</button>
                    </div>
                </div>
                <span v-if="errorField.price" class="text-danger">{{ errorField.price[0] }}</span>
            </div>
        </form>
    </div>
</template>


<script>
    export default {
        data() {
            return {
                loadPackage: false,
                loadDelivery: false,
                loadOrder: false,
                price: null,
                packageSelect: '',
                packges: {},
                packgeDays: {},
                orderId: null,
                errorMessage: null,
                errorField: {},
                datePickerDate: new Date(),
                datePickerOptions: {
                    format: 'DD.MM.YYYY',
                    daysOfWeekDisabled: [],
                    minDate: new Date(),
                    locale: 'ru'
                }
            }
        },
        mounted() {
            this.init();

        },
        methods: {
            sendOrder (e) {
                this.loadOrder = true;
                this.errorMessage = null;
                this.orderId = null;
                this.errorField = {};
                e.preventDefault();
                let form = new FormData(this.$refs.order);
                this.$http.post('/api/order/create', form)
                    .then((response) => {
                        this.loadOrder = false;
                        let result = response.data;
                        if (result.status) {
                            this.orderId = result.data.orderId;
                        } else {
                            this.errorMessage = '[' + result.code + '] ' + result.message;
                        }
                    }).catch((error) => {
                        this.loadOrder = false;
                        if (error instanceof Object) {
                            this.errorField = error;
                        } else {
                            this.errorMessage = error;
                        }
                    });
            },
            init : function () {
                this.loadPackage = true;
                this.loadDelivery = true;
                this.getPackages().then(() => {
                    this.price = this.packges[0].price;
                    this.loadDelivery = false;
                    this.loadPackage = false;
                    let self = this;
                    $.each(this.packges, function (key, value) {
                        self.getDateByPackage(value.id);
                    });
                });
            },
            getPackages : async function () {
                return this.$http.get('/api/package/list')
                    .then((response) => {
                        let result = response.data;
                        if (result.status) {
                            let $select = $('.vue-select2 ').find('select');
                            this.packges = result.data;
                            $.each(this.packges, function (key, value) {
                                let option = new Option(value.name + ' (' + value.price + ')', value.id, false, false);
                                $select.append(option).trigger('change');
                            });
                        } else {
                            this.errorMessage = result.code + " - " + result.message;
                        }
                    })
                    .catch((error) => {
                        this.errorMessage = error.message;
                    });
            },
            changePackage : function (packageId) {
                this.loadDelivery = true;
                if (this.packgeDays[packageId] == undefined) {
                     this.getDateByPackage(packageId).then(() => {
                         this.changePackageEnd(packageId);
                     });
                } else {
                    this.changePackageEnd(packageId);
                }
            },
            changePackageEnd : function (packageId) {
                this.updateDeliveryOption(packageId);
                this.changePrice();
                this.loadDelivery = false;
            },
            getDateByPackage : async function (packageId) {
                return this.$http.get('/api/package/' + packageId + '/days-of-weak')
                    .then((response) => {
                        let result = response.data;
                        if (result.status) {
                            let packgeDays = [];
                            $.each(result.data, function (index, value) {
                                let day = value['day_id'] == 7 ? 0 : value['day_id'];
                                packgeDays.push(day);
                            });
                            this.packgeDays[packageId] = packgeDays;
                        } else {
                            this.errorMessage = '[' + result.code + '] ' + result.message;
                        }
                    })
                    .catch((error) => {
                        this.errorMessage = error.message;
                    });
            },
            updateDeliveryOption : function (packageId) {
                let mapWeak = [0,1,2,3,4,5,6];
                $.each(this.packgeDays[packageId], function (index, value) {
                    mapWeak.splice(mapWeak.indexOf(value), 1);
                });
                if (!mapWeak.length) {
                    mapWeak = null;
                }
                this.datePickerOptions.daysOfWeekDisabled = mapWeak;

                this.loadDelivery = false;
            },
            changePrice : function () {
                let self = this;
                $.each(this.packges, function (index, value) {
                    if (value.id == self.packageSelect) {
                        self.price = value.price;
                    }
                });
            }
        }
    }
</script>
