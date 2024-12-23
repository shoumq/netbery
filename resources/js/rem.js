function onRem() {
    let iOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
    let iw = (iOS) ? screen.width : window.innerWidth, ih = (iOS) ? screen.height : window.innerHeight;

    let container_width = 1920; //кол-во пикселей, меньше которого включается резиновость,
    //сюда рекомендуется писать шиирину контейнера в фигме + 150 ~ 200px


    let mobile_width = 320; //Ширина мобильного фрейма в фигме
    switch (true) {
        case (iw > 650):
            document.documentElement.style.fontSize = iw / container_width + 'px'
            break
        case (iw < 650):
            document.documentElement.style.fontSize = iw / mobile_width + 'px'
            break
    }
}

window.addEventListener('resize', onRem)

onRem()
