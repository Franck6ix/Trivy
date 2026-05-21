<x-layouts.app title="Trivy — Préparation de votre voyage">
    <div class="mobile-shell flex min-h-dvh flex-col items-center justify-center px-6"
         style="background: var(--gradient-navy)"
         x-data="{
             progress: 0,
             currentTask: 0,
             tasks: [
                 { label: 'Analyse du climat',       done: false },
                 { label: 'Sélection d\'activités',  done: false },
                 { label: 'Optimisation bagages',    done: false },
                 { label: 'Planification proactive', done: false }
             ],
             init() {
                 let step = 0;
                 const interval = setInterval(() => {
                     step++;
                     this.progress = Math.min(step * 2, 100);

                     if (step === 15) { this.tasks[0].done = true; this.currentTask = 1; }
                     if (step === 30) { this.tasks[1].done = true; this.currentTask = 2; }
                     if (step === 40) { this.tasks[2].done = true; this.currentTask = 3; }
                     if (step === 48) { this.tasks[3].done = true; this.currentTask = 4; }

                     if (step >= 50) {
                         clearInterval(interval);
                         setTimeout(() => { window.location.href = '{{ route('dashboard') }}'; }, 600);
                     }
                 }, 80);
             }
         }">

        {{-- Suitcase with spinning rings --}}
        <div class="relative flex h-56 w-56 items-center justify-center">
            <div class="absolute inset-0 animate-spin-slow rounded-full border-2 border-dashed"
                 style="border-color: rgba(201,168,76,0.4)"></div>
            <div class="absolute rounded-full border border-dashed"
                 style="inset: 16px; border-color: rgba(201,168,76,0.2); animation: trivy-spin-slow 6s linear infinite reverse;"></div>
            <img src="{{ asset('images/suitcase.png') }}" alt="Valise"
                 class="animate-bob h-32 w-32 object-contain drop-shadow-2xl">
        </div>

        <p class="mt-8 text-xs uppercase tracking-brand font-semibold" style="color: var(--gold)">Génération en cours</p>
        <p class="mt-2 font-display text-xl font-semibold text-white">Préparation de votre voyage</p>

        {{-- Progress bar --}}
        <div class="mt-6 h-1.5 w-full max-w-xs overflow-hidden rounded-full"
             style="background: rgba(255,255,255,0.1)">
            <div class="h-full rounded-full transition-all duration-150 ease-out"
                 style="background: var(--gradient-gold)"
                 :style="'width: ' + progress + '%'"></div>
        </div>

        {{-- Task list --}}
        <ul class="mt-6 w-full max-w-xs space-y-2.5 text-sm">
            <template x-for="(task, i) in tasks" :key="i">
                <li class="flex items-center gap-3 text-white transition-opacity duration-500"
                    :class="i > currentTask ? 'opacity-40' : 'opacity-100'">
                    <span class="grid h-5 w-5 shrink-0 place-items-center rounded-full transition-all duration-300"
                          :style="task.done
                              ? 'background: var(--gradient-gold)'
                              : i === currentTask
                                  ? 'border: 1px solid rgba(201,168,76,0.6); background: rgba(201,168,76,0.1)'
                                  : 'border: 1px solid rgba(255,255,255,0.2)'">
                        <svg x-show="task.done" x-transition:enter="transition duration-200"
                             x-transition:enter-start="opacity-0 scale-50" x-transition:enter-end="opacity-100 scale-100"
                             xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="3" style="color: var(--navy)">
                            <path d="M20 6 9 17l-5-5"/>
                        </svg>
                        <span x-show="!task.done && i === currentTask"
                              class="h-1.5 w-1.5 rounded-full animate-pulse"
                              style="background: var(--gold)"></span>
                    </span>
                    <span x-text="task.label"></span>
                </li>
            </template>
        </ul>

        <p class="mt-auto pt-10 text-center text-xs" style="color: rgba(255,255,255,0.4)">
            Zéro charge mentale — l'IA s'occupe de tout.
        </p>
    </div>
</x-layouts.app>
