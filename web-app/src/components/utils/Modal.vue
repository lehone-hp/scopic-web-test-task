<template>
  <transition name="modal-fade" v-if="is_modal_visible">
    <div class="hp-modal-backdrop">
      <div class="hp-modal" :class="size">
        <div class="hp-modal-header">
          <slot name="header">
            <h4 class="modal-title">{{ title }}</h4>
          </slot>
          <button
              type="button"
              class="btn-close"
              @click="hide">
            &times;
          </button>
        </div>

        <section class="hp-modal-content">
          <div class="hp-modal-body">
            <slot></slot>
          </div>
          <div class="hp-modal-footer" v-if="!hidefooter">
            <slot name="footer">
              <button class="btn btn-light mr-2"
                      @click="hide">Close
              </button>
              <button :class="getOkStyle"
                      @click="okayClicked"
                      v-html="oktext_display">
              </button>
            </slot>
          </div>
        </section>
      </div>
    </div>
  </transition>
</template>

<script>
export default {
  name: "Modal",
  props: ['title', 'oktext', 'okstyle', 'size', 'hidefooter'],
  data: function () {
    return {
      'is_modal_visible': false,
      'oktext_display': this.oktext ? this.oktext : 'Okay',
    }
  },
  computed: {
    getOkStyle: function () {
      var cl = 'default-btn';
      if (this.okstyle === 'danger') {
        cl = 'btn btn-red'
      }
      return cl;
    }
  },
  methods: {
    show() {
      this.is_modal_visible = true;
      this.$emit('open');
    },
    hide() {
      this.is_modal_visible = false;
      this.$emit('close');
    },
    okayClicked() {
      this.$emit('ok');
    }
  },
}
</script>

<style>
.modal-fade-enter,
.modal-fade-leave-to {
  opacity: 0;
}

.modal-fade-enter-active,
.modal-fade-leave-active {
  transition: opacity .5s ease;
}

.hp-modal-backdrop {
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  background-color: rgba(0, 0, 0, 0.3);
  z-index: 10000;
  overflow-y: auto;
  padding: 15px;
}

.hp-modal {
  background: #FFFFFF;
  display: flex;
  flex-direction: column;
  width: 100%;
  margin-left: auto;
  margin-right: auto;
  margin-top: 4rem;
  position: relative;
  overflow: hidden;
  border-radius: 10px;
}

.hp-modal-header {
  display: flex;
  font-family: "Amble Regular";
  justify-content: space-between;
}

.hp-modal-footer {
  text-align: right;
}

.hp-modal-header,
.hp-modal-body,
.hp-modal-footer {
  padding: 15px;
}

.btn-close {
  position: absolute;
  top: 0;
  right: 0;
  border: none;
  font-size: 25px;
  padding: 10px 15px;
  cursor: pointer;
  font-weight: bold;
  color: #a4a4a4;
  background: transparent;
  outline: none;
}

@media (min-width: 576px) {
  .hp-modal {
    max-width: 520px;
  }

  .hp-modal.sm {
    max-width: 360px;
  }

  .hp-modal.lg {
    max-width: 500px;
  }

  .hp-modal-header,
  .hp-modal-body,
  .hp-modal-footer {
    padding: 20px 40px;
  }

  .btn-close {
    padding: 20px 17px;
  }
}

@media (min-width: 992px) {
  .hp-modal {
    max-width: 720px;
  }

  .hp-modal.sm {
    max-width: 520px;
  }

  .hp-modal.lg {
    max-width: 850px;
  }
}

</style>