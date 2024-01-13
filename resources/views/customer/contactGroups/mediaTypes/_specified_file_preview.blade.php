<div class="preview-box">
    <h3 class="fw-bolder my-2">Preview</h3>
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                {{-- {{ dd($messageData->mediaType) }} --}}

                @if (@$messageData)
                    <div class="spacifed-img" style="display: {{$messageData->mediaType == "image" ? 'block' : 'none'}}">
                        <img src="{{ @$messageData->filePath }}" alt="" width="100px" id="spacified-img">
                    </div>

                    <div id="divVideo" style="display:{{$messageData->mediaType == "video" ? 'block' : 'none'}}; text-align:center;">
                        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAPoAAACtCAMAAACuuZJAAAAAAXNSR0IB2cksfwAAAAlwSFlzAAALEwAACxMBAJqcGAAAAY9QTFRF0dPU0tTV1NbX1dbX1tfY1tjZ1dfY09XW3N7f5Obm7e7u8/T0+Pj4+vr6+/v7/Pz8+/z8+fr69vb28PHy6enq4eLi2drb19jZ4uPk8fHy/////f396err3N3e293d6Onp9fX1/P39/v7+7/Dw4ePj4eLj+Pn52Nrb4+Tl+fn55+jp293e2Nra19na2tvc3t/g6uvs8PHx9vb38PDx29zd0tTU4uPj1dfX6Onq9vf39/f37u/v2Nna/f3+3+Hh2dvc3+Dh3d7f5+jo7e3u6+zs9PT02tzd8vPz4uTk8fLy7O3t3+Dg6+zt3d/f+vv719nZ1NbW3d/g6uvr09TV3uDg9fX28/P04OHi/f7+1NXW4+Tk/v//9/j48vLz3uDh8/Pz5ebn6erq9fb2+/v85ebm7O3u7u7v8vLy9PX17e7v4+Xl5efn3N7e5ufo+vr77Ozt6+vs+fn65OXl5OXm5ubn7/Dx5ujo/v7/1tjY+Pj55ufn9/f4/Pz92tzc9PT10tPU4OLi8fHx7u/w8PDw5+npU/NnWgAAB0dJREFUeJztnHtbE0cUxtlIshpIItRCmADBDQECDUilBRIqFwWFAqkoghaqAlK1Xmqvii3aywfvnNmEQMjO7GZnN7v0/P7dyT7vm7mdOTOzDQ0IgiAIgiAIgiAIgiAIgiAIgiAIgiAIgiAIgiCImyiBc43BYCigKvVW4iah8xfCTc2RaCwWuxhtaf3k0qdt/wP/Snu8I0JOk2jt7FLrLc5BlO5kz+UqvnW0llRvqN4SnUFNd2iGvov0dfbXW6Z8zg20lFt3pik8mB76LBgKZodHBq6Mfh4t/ylXx76ot1apKPGjDh5NfZmt7NXKePfEZMm9lsrWRaMzpPuKtnLJYcNCgXQ+VjQfPivmp/JfMUeXO66d4xZUpieadfOZ+JmY7WaKnXx01kTh8bmMXvHX+f+SH1Bv6Mbnh0z+QEnqzT6y4Kgu5wnc1Me2WxYacHZRnwfizslygSG9+S4FrP3sa73LL/u4w6+sgoNVK1WuU7iqj/TfOKHKDW6zXttcS6dV19g0n/Jpvc8y9TctNvYSvQnm3ZdrmmyUTWl3av39XdZmlmRKcokpNp0v2Wixw+wNnfIkuYS6DrrDttrrLNS71itLkksoy+D8ns2eurEJMUGbHElu0QvOW+/bfc2Db+lrtnw11GVheI5JWH+Ffdfdt0HxdxJepDyE7j4i4U0uEdekhaFTMEVu1RgbuE8AQvCMpBTjI2hAj+S8y3keg9oV4+fZlIVaVHZglPdJtQdgjNvmFCiQyUbzrxvS/DPSQXIi1s4pUKDPLSzGl+j7doO2ZblA+0VR6F2ARMSc6VEwmPBLte+BMW4lFVgi4onpSGUfersP4hoFMu5hbhHdOpk0G/JkYbcqbV+a04yAq/PcIkXrZJVfrMz3tPBT72ctnkHwzi9Ssk5I0pyfWQjppiWIcxTW3p/zy5Sta2FTgY8CMdIPMuQ5yQsY5Kb4ZcrWCZnnzYJHwHy5LkOek8Ak3CNoxsetkygn7DviLpQ09SfVD6WVatwTFDphnWhz4teqMLV7PF0TgpyS6HjASeuE5MURegctdkOORKc4D0GsaNiutE6eCs9SQJzUJEmjQ7ykEndEhU5ZJxnRLixMb68kaXSIUSrxtajQaeuEDPB/0g6d3dtLmBxVKFyUVbOu7XP3KlQIF+7K0+kAsGrrFhWqZp32E2400EM8nqtRNRrQFESlqlsnfbzsY4oW+FGiUumEqMBdYWxqYJ0kbhn/Zo0+z8uUKpssFRgRztJG1glZM1yVz9Gno3LFymWaCswIkwrG1smOUZMZoA9vSlYrlQW71knEYA0P1u/JlisT+9Z7DJblnrcODf6NHeuLRgPFT4Sf4K47Noc5zThr4/lhDia3WO2T24zxb67Q5/sSlUqHhTTCRKuB9R3eGQJYHKxJVCof2BftEhWqal1L8VoLS4H8LFGofCaJcBFmsHzp5K7yA7B8uS1PpwNAqH1dVKiK9ZhghwGOaWjevhnzCxFm4atZz4mS7LCxEZGk0SHGYJyznKD6VXgWFuY2T0/rdHaDcU50KLbCemJCvJXYRDy/2arAScHfBIVOWk88EL82AMcLNqQodA4IPVqtbEFkjC8ClZmhBX9/K0Wgc4xRkZuC3PJx64um7rg8IZ7PRVPeUZUH/CLHthsHTW21sj1MYbhQd+BwbDPf0JF1sydqNmBI8P6VzxXwxN9RKFkXbjyUgLtD894/WqC8J6LlZdH6ttnjMdNwQNoPh0Uhn8JfvenWJ0zfj4A7QK+8X+k0qoFrTileiYKJoP0Y/Zp45PQIg1TpH39yClDrW2a7Oe1BsCSKeHvpUiIAe+y8xHGBHFrYOXwBlf7Ytip3uABdmdOgC48tdFwVLkj2+aGnA2qOql2VtCWcJL4IZ0qsQBsdlVJTC7CxfuiXSqfkoaoEp+dMEYDT8IkxCW9yiyzss+9KON8IZy99M8bpsCb/xnZ3Zx19XoYg9/gwAaInbZ7kZteHIt4+QnMahX164KGtOysfwXnC7PFp79AIAxT5a7z2N8zsQm7G2/sO1elnF5EXa77cucEucfvzow1t7AL7Vm3XO5WXbHm35kvnNBxh3l+ZX6mUUVNwkZe89qlz2ubfsQSciTx7BcNsoOBst3uf/kPWbDusXUFX99jHuhIvfey8oWG8g3mP7llwMT1qKWfpXfbYl0ZIS9qk+bf7eubO8BiZj1gofnFtfcZE4dBSVE/QJ31wpU+Mmix+UDJ3wJ/olJG/E8UqF57M8AsvHhY/IRh5thE0aPj3F+YOi8ZX585AYy9xJ/6+tOMSyV8YO9WYCzOdPaUPLCbC3t9nscZKT/nTmVrLvaWD9MrQWHfXtYFL/0zGjp6Q3StnqMZLKEPhyo+pnvq4am7gDBpnhOKpaKXb8v/Q2tn9od4KHUSZ+rg8H9mstB1rvnrQ5ZPvUdgi0L/xb34+l1mNRiPN64vLz7safR2yIgiCIAiCIAiCIAiCIAiCIAiCIAiCIAiCIAiCIIg/+A/50CvRH3pLHQAAAABJRU5ErkJggg=="
                            alt="" style="width:100%">
                    </div>
                    <div id="divaudio" runat="server" style="display:{{$messageData->mediaType == "audio" ? 'block' : 'none'}};">
                        <audio id="modalPlayer"
                            onload="('#modalPlayer').src={{ @$messageData->filePath }};"
                            controls="controls">
                        </audio>
                    </div>
                @else
                    <div class="spacifed-img">
                        <img src="{{ @$messageData->filePath }}" alt="" width="100px" id="spacified-img">
                    </div>

                    <div id="divVideo" style="display:none; text-align:center;">
                        <img src="data:image/png;base64,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"
                            alt="" style="width:100%">
                    </div>
                    <div id="divaudio" runat="server" style="display:none;">
                        <audio id="modalPlayer"
                            onload="('#modalPlayer').src=http://localhost:8000/public/upload/messageFiles/1685354529.mp3;"
                            controls="controls">
                        </audio>
                    </div>
                @endif

                <div class="specified-preview">
                    <p class="img-cap">{{ @$messageData->mediaType != "audio" ? @$messageData->message : '' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
