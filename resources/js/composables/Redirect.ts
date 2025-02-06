import { useRouter } from "vue-router";

export function useRedirect() {
    const router = useRouter();

    const redirect = (url, id) => {
        router.push({ name: url, params: { id } });
    };

    return redirect; // Retornar directamente la función
}
