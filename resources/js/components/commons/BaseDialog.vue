<template>
<!--    <teleport to="body">-->
        <dialog open :class="nameDialogStyle">
            <div class="dialog-detail-new">
                <header :class="customClassStyle">
                    <slot name="header">
                        <span :class="customClassStyle">{{ title }}</span><hr/>
                    </slot>
                </header>
                <section>
                    <slot></slot>
                </section>
            </div>
        </dialog>
<!--    </teleport>-->
</template>

<script>
export default {
    components: {
        // BaseButton
    },
    props: {
        title: {
            type: String,
            require: false
        },
        customClass: {
            type: String,
            require: false
        },
        nameDialog: {
            type: String,
            require: false
        }
    },
    emits: ['close'],
    data() {
        return {
            customClassStyle: '',
            nameDialogStyle: ''
        }
    },
    created() {
        this.customClassStyle = this.customClass
        this.nameDialogStyle = this.nameDialog
    },
    methods: {

    }
}
</script>

<style lang="scss" scoped>
.dialog-detail-new {
    padding-top: 32px;
    padding-left: 32px;
    padding-right: 32px;
}
dialog {
    position: fixed;
    top: 13vh;
    width: 80%;
    z-index: 100;
    height: auto;
    border-radius: 10px;
    background-color: #ffffff;
    border: none;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.26);
    padding: 0;
    margin: auto;
    overflow: hidden;
}
.dialog-warning {
    position: fixed;
    top: 42vh;
    left: 50vh;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    width: 488px !important;
    height: 264px !important;
    background: #FFFFFF;
    border-radius: 10px;
}
header span {
    font-style: normal;
    font-weight: 700;
    font-size: 32px;
    line-height: 38px;
    color: #101010;
    display: inline-block;
}
.title-warning {
    text-align: center !important;
    font-style: normal;
    font-weight: 600;
    font-size: 20px;
    line-height: 23px;
    color: #FC3840 !important;
}
section {
    overflow: auto;
    height: 500px;
    margin-bottom: 20px;
    padding-bottom: 20px;
    .warning-pin {
        padding-top: 38px;
        text-align: center;
    }
    .button-event {
        text-align: center;
        .button-submit {
            width: 107px;
            height: 43px;
            background: #FC3840;
            border-radius: 30px;
            font-weight: 500;
            font-size: 16px;
            line-height: 19px;
            color: #FFFFFF;
            border: none;
        }
        .button-cancel {
            border: none;
            width: 99px;
            height: 42px;
            background: #FFFFFF;
            font-style: normal;
            font-weight: 500;
            font-size: 14px;
            line-height: 125%;
            color: #757575;
        }
    }
}
.comment-message-detail {
    padding-top: 32px;
}
.more-setting {
    padding-top: 5px;
    position: absolute;
    right: 0;
    margin-right: 32px;
}
.name-user-message-detail {
    display: block;
    padding-top: 15px;
    font-style: normal;
    font-weight: 400;
    font-size: 16px;
    line-height: 19px;
    color: #101010;
}
.date-message-detail {
    display: block;
    padding-top: 8px;
    font-style: normal;
    font-weight: 400;
    font-size: 14px;
    line-height: 16px;
    color: #757575;
}
.attach-document {
    padding-top: 16px;
    font-style: normal;
    font-weight: 400;
    font-size: 16px;
    line-height: 19px;
    color: #0085F9;
}
.label-comment {
    font-style: normal;
    font-weight: bold;
    font-size: 16px;
    line-height: 19px;
    color: #101010;
}
.input-comment {
    height: 128px !important;
    background: #F3F3F3 !important;
    border-radius: 10px !important;
}
.button-submit-comment {
    right: 0;
    width: 107px;
    height: 43px;
    background: #FC3840;
    border-radius: 30px;
    border: none;
    font-style: normal;
    font-weight: 500;
    font-size: 16px;
    line-height: 19px;
    color: #FFFFFF;
    margin-top: 15px;
}
@media (min-width: 768px) {
    dialog {
        margin: auto;
        width: 924px;
    }
}
</style>
