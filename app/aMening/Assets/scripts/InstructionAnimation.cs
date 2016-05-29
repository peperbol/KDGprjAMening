using UnityEngine;
using System.Collections;
using UnityEngine.UI;
using System.Linq;
/// <summary>
/// plays the animation of the swipe instruction
/// </summary>
public class InstructionAnimation : MonoBehaviour {

    public AnimationCurve movement;
    public float playTime = 3;
    public float fadeout;

    private Image image;
    private SwipeInput swipeInput;
    private Transform visual;

    void Start () {
        swipeInput = FindObjectOfType<SwipeInput>();
	}
    float Alpha {
        get {
            return image.color.a;
        }
        set {
            Color c = image.color;
            c.a = value;
            image.color = c;
        }
    }
    bool done;
    public void Play(GameObject obj, bool play)
    {

        var visual = obj.GetComponentsInChildren<Transform>().First(e => e.gameObject.name == "instruction");
        if (!done && play)
        {
            StartCoroutine(Animation(obj, visual, visual.GetComponentInChildren<Image>()));
            done = true;
        }
        else
        {
            visual.gameObject.SetActive(false);

        }
    }
    IEnumerator Animation(GameObject obj, Transform visual, Image image)
    {
        this.visual = visual;
        this.image = image;
        Debug.Log(this.visual.gameObject.name);
        float timer = 0;
        swipeInput.selected = true;
        while(timer < playTime)
        {
            timer += Time.deltaTime;
            swipeInput.Split = movement.Evaluate(timer / playTime);
            if (timer > playTime - fadeout)
                Alpha = (playTime - timer) / fadeout;
            yield return null;
        }
        Alpha = 0;

        Debug.Log(Alpha);
        swipeInput.selected = false;
        this.visual.gameObject.SetActive(false);
    }
}
