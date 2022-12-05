document.addEventListener('DOMContentLoaded', function () {

  LottieInteractivity.create({
    mode: 'cursor',
    player: '#mission',
    actions: [
        {
          type: "hover",
          forceFlag: false
        }
    ]
  });

  LottieInteractivity.create({
    mode: 'cursor',
    player: '#solution',
    actions: [
        {
          type: "hover",
          forceFlag: false
        },
      ],
  });

});