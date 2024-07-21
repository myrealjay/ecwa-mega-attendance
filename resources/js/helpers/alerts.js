import swal from 'sweetalert';

class Alert{
    success(text) {
        swal({
            title: 'Congratulations!',
            text,
            icon: 'success',
            button: {
              text: "Okay",
              value: true,
              visible: true,
              className: "btn btn-primary"
            }
        })
    }

    dialog(text) {
        return swal({
            text,
            buttons: [
                {
                    text: "Cancel",
                    value: false,
                    visible: true,
                    className: "btn btn-warning"
                  },
                {
                    text: "Okay",
                    value: true,
                    visible: true,
                    className: "btn btn-primary"
                }
            ]
        })
    }

    error(text) {
        swal({
            title: '!Opps',
            text,
            icon: 'error',
            button: {
              text: "Okay",
              value: true,
              visible: true,
              className: "btn btn-primary"
            }
        })
    }
}

export function sweetAlert() {
    return new Alert();
}