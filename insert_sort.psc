algorithm InsertSort(in: pole, n) {
    for (d: 1 ⇝ n-1, +) {
        vkladany ← pole[d] // odložení vkládaného
        i ← d // i je index hledané pozice
        while((i > 0) AND (pole[i-1] > vkladany)){
            pole[i] ← pole[i-1]
            i ← i - 1
        } // while
        pole[i] ← vkladany // vložení vkládaného
    } // for d
}
