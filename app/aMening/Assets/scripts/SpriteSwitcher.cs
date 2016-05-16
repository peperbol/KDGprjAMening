using UnityEngine;
using System.Collections;
using UnityEngine.UI;

[RequireComponent(typeof(Image))]
public class SpriteSwitcher : MonoBehaviour {
    public Sprite[] sprites;
    Image i;
    int index;
    public float interval = 0.5f;

    float timer;
    int Index { get { return index; }
        set
        {
            index = value % sprites.Length;

            i.sprite = sprites[index];
        }
    }
	void Start () {
        i = GetComponent<Image>();
	}

	void Update () {
        timer -= Time.deltaTime;
        if(timer < 0)
        {
            timer += interval;
            Index++;
        }
	}
}
