<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    pdf Here <span class="write"></span>


                </div>
            </div>
        </div>
        <canvas id="the-canvas"></canvas>
      
    </div>
    @push('customJS')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/devtools-detector/2.0.14/devtools-detector.js"
        integrity="sha512-ZiYgUI2NVB760mprMoZ2WTZ/KslDohbAm6QsGBmqpWDsVkJ2V7gEIAaQHj3/EutqpQWeryBiGHjg3JyWQ4EewQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.min.js"
        integrity="sha512-ml/QKfG3+Yes6TwOzQb7aCNtJF4PUyha6R3w8pSTo/VJSywl7ZreYvvtUso7fKevpsI+pYVVwnu82YO0q3V6eg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        let canvas = document.querySelector('canvas')
        devtoolsDetector.addListener(function(isOpen) {
        if(isOpen){
            canvas.remove();
        }
        //* DO SOMETHING IF DEV TOOL IS OPEN
        
    });
   devtoolsDetector.launch();
    </script>
    <script>
        var url = `{{ route('get-pdf') }}`;

        
        pdfjsLib.getDocument(url).promise.then(function(pdf) {
            console.log(url)
            pdf.getPage(1).then(function(page) {
           var scale = 1.5;
        var viewport = page.getViewport({ scale: scale, });
        // Support HiDPI-screens.
        var outputScale = window.devicePixelRatio || 1;
        
        var canvas = document.getElementById('the-canvas');
        var context = canvas.getContext('2d');
        canvas.oncontextmenu = function() {return false};
        canvas.width = Math.floor(viewport.width * outputScale);
        canvas.height = Math.floor(viewport.height * outputScale);
        canvas.style.width = Math.floor(viewport.width) + "px";
        canvas.style.height = Math.floor(viewport.height) + "px";
        
        var transform = outputScale !== 1
        ? [outputScale, 0, 0, outputScale, 0, 0]
        : null;
        
        var renderContext = {
        canvasContext: context,
        transform: transform,
        viewport: viewport
        };
        page.render(renderContext);
            });
        })

    </script>
    @endpush
</x-app-layout>