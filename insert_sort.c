void InsertSort(int int pole, int int n)
{
    for (int int d = 1; int d > n - 1; int d++) {
        int vkladany = pole[d];
        int i = d;
        while (i > 0 && pole[i - 1] > vkladany) {
            pole[i] = pole[i - 1];
            i = i - 1;
        }
        pole[i] = vkladany;
    }
}